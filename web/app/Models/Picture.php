<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Traits\StringKey;
use App\Traits\UrlAttribute;
use App\Traits\Filename;
use App\Traits\LikeSearchScope;
use App\Http\Requests\StorePicture;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class Picture extends Model
{
    use StringKey;
    use UrlAttribute;
    use Filename;
    use LikeSearchScope;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $appends = [
        'url', 'liked_by_user'
    ];

    protected $visible = [
        'id', 'artist', 'url', 'title', 'liked_by_user'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!Arr::get($this->attributes, 'id')) {
            $this->setStringId($attributes);
        }
    }

    /**
     * Accessor for 'url'
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->setUrlAttribute();
    }

    /**
     * Accessor for 'liked_by_user'
     *
     * @return boolean
     */
    public function getLikedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return $this->picture_liked_by->contains(Auth::user());
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
        $pictures = Picture::with(['artist', 'artist.profile_picture'])
            ->whereIn('user_id', self::getFollowingUsersKeys())
            ->latest()
            ->paginate();

        return $pictures;
    }

    public static function getLikedPictures()
    {
        $pictures = Auth::user()
            ->picture_likes()
            ->with(['artist', 'artist.profile_picture'])
            ->latest()
            ->paginate();

        return $pictures;
    }

    public static function getUserPictures(User $user)
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

        $picture->filename = $picture->getFilename($extension);
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

        return $picture;
    }

    public static function deletePicture(Picture $picture)
    {
        $picture->delete();
        Storage::cloud()->delete($picture->filename);
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

    public static function searchPictures($keyword)
    {
        return Picture::with(['artist', 'artist.profile_picture'])
            ->LikeSearch($keyword, 'title')
            ->latest()
            ->get();
    }

    private static function getFollowingUsersKeys()
    {
        return Auth::user()->follows()->get()->modelKeys();
    }
}
