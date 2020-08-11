<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Traits\StringKey;
use App\Traits\UrlAttribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTrack;

class Track extends Model
{
    use StringKey;
    use UrlAttribute;

    protected $keyType = 'string';

    public $incrementing = false;

    const ID_LENGTH = 12;

    protected $appends = [
        'url', 'liked_by_user'
    ];

    protected $visible = [
        'id', 'artist', 'url', 'title', 'artwork', 'liked_by_user'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!Arr::get($this->attributes, 'id')) {
            $this->setStringId($attributes);
        }
    }

    public function getUrlAttribute()
    {
        return $this->setUrlAttribute();
    }

    public function getLikedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return $this->track_liked_by->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }

    public function artwork()
    {
        return $this->hasOne('App\Models\Artwork', 'track_id', 'id');
    }

    public function artist()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id', 'users');
    }

    public function track_liked_by()
    {
        return $this->belongsToMany('App\Models\User', 'track_likes', 'track_id', 'user_id')->withTimestamps();
    }

    public static function getNewTracks()
    {
        $tracks = Track::with(['artist', 'artwork'])
            ->latest()
            ->paginate();

        return $tracks;
    }

    public static function getFeedTracks()
    {
        $tracks = Track::whereHas('artist', function (Builder $query) {
            $query->whereIn('id', Auth::user()->follows()->get()->modelKeys());
        })->with(['artist', 'artwork'])
            ->latest()
            ->paginate();

        return $tracks;
    }

    public static function getLikedTracks()
    {
        $tracks = Track::whereHas('track_liked_by', function (Builder $query) {
            $query->where('id', Auth::id());
        })->with(['artist', 'artwork'])
            ->latest()
            ->paginate();

        return $tracks;
    }

    public static function getUserProfileTracks(User $user)
    {
        $tracks = Track::with(['artist', 'artwork'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate();

        return $tracks;
    }

    public static function storeTrack(StoreTrack $request)
    {
        $extension = $request->track->extension();

        $track = new Track();

        $track->filename = $track->id . '.' . $extension;
        $track->title = $request->title;

        Storage::cloud()
            ->putFileAs('', $request->track, $track->filename, 'public');


        DB::beginTransaction();

        try {
            Auth::user()->tracks()->save($track);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Storage::cloud()->delete($track->filename);
            throw $exception;
        }

        Artwork::storeArtwork($request, $track);
    }

    public static function deleteTrack(Track $track)
    {
        $artwork = $track->artwork;
        Storage::cloud()->delete($track->filename);
        Storage::cloud()->delete($artwork->filename);

        DB::beginTransaction();

        try {
            $track->delete();
            $artwork->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Storage::cloud()
                ->putFileAs('', $track, $track->filename, 'public');
            Storage::cloud()
                ->putFileAs('', $artwork, $artwork->filename, 'public');
            throw $exception;
        }
    }

    public static function likeTrack(Track $track)
    {
        $track->track_liked_by()->detach(Auth::id());
        $track->track_liked_by()->attach(Auth::id());
    }

    public static function unlikeTrack(Track $track)
    {
        $track->track_liked_by()->detach(Auth::id());
    }
}
