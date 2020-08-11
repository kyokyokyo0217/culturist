<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Traits\StringKey;
use App\Http\Requests\StorePicture;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Picture extends Model
{
    use StringKey;

    protected $keyType = 'string';

    const ID_LENGTH = 12;

    protected $appends = [
        'url', 'liked_by_user'
    ];

    protected $visible = [
        'id', 'artist', 'url', 'title', 'liked_by_user'
    ];

    public function getUrlAttribute()
    {
        return Storage::cloud()->url($this->attributes['filename']);
    }

    public function getLikedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return $this->picture_liked_by->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!Arr::get($this->attributes, 'id')) {
            $this->setStringId($attributes);
        }
    }

    public function artist()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id', 'users');
    }

    public function picture_liked_by()
    {
        return $this->belongsToMany('App\Models\User', 'picture_likes', 'picture_id', 'user_id')->withTimestamps();
    }

    public static function getNewPictures()
    {
        $pictures = Picture::with(['artist', 'artist.profile_picture'])
            ->latest()
            ->paginate();

        return $pictures;
    }

    public static function getFeedPictures()
    {
        $pictures = Picture::whereHas('artist', function (Builder $query) {
            $query->whereIn('id', Auth::user()->follows()->get()->modelKeys());
        })->with(['artist', 'artist.profile_picture'])
            ->latest()
            ->paginate();

        return $pictures;
    }

    public static function getLikedPictures()
    {
        $pictures = Picture::whereHas('picture_liked_by', function (Builder $query) {
            $query->where('id', Auth::id());
        })->with(['artist', 'artist.profile_picture'])
            ->latest()
            ->paginate();

        return $pictures;
    }


    public static function getUserProfilePictures(User $user)
    {
        $pictures = Picture::with(['artist', 'artist.profile_picture'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate();

        return $pictures;
    }

    public static function storePicture(StorePicture $request)
    {
        $extension = $request->picture->extension();

        $picture = new Picture();

        $picture->filename = $picture->id . '.' . $extension;
        $picture->title = $request->title;

        Storage::cloud()
            ->putFileAs('', $request->picture, $picture->filename, 'public');


        DB::beginTransaction();

        try {
            Auth::user()->pictures()->save($picture);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Storage::cloud()->delete($picture->filename);
            throw $exception;
        }
    }

    public static function deletePicture(Picture $picture)
    {
        Storage::cloud()->delete($picture->filename);

        DB::beginTransaction();

        try {
            $picture->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Storage::cloud()
                ->putFileAs('', $picture, $picture->filename, 'public');
            throw $exception;
        }
    }

    public static function likePicture(Picture $picture)
    {
        $picture->picture_liked_by()->detach(Auth::id());
        $picture->picture_liked_by()->attach(Auth::id());
    }

    public static function unlikePicture(Picture $picture)
    {
        $picture->picture_liked_by()->detach(Auth::id());
    }
}
