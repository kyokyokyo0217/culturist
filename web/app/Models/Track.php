<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Traits\StringKey;
use App\Traits\UrlAttribute;
use App\Traits\Filename;
use App\Traits\LikeSearchScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTrackWithArtwork;

class Track extends Model
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
        'id', 'artist', 'url', 'title', 'artwork', 'liked_by_user'
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

        return $this->track_liked_by->contains(Auth::user());
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
        $tracks = Track::with(['artist', 'artwork'])
            ->whereIn('user_id', Auth::user()->follows()->get()->modelKeys())
            ->latest()
            ->paginate();

        return $tracks;
    }

    public static function getLikedTracks()
    {
        $tracks = Auth::user()
            ->track_likes()
            ->with(['artist', 'artwork'])
            ->latest()
            ->paginate();

        return $tracks;
    }

    public static function getUserTracks(User $user)
    {
        $tracks = Track::with(['artist', 'artwork'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate();

        return $tracks;
    }

    public static function storeTrack($request)
    {
        $extension = $request->track->extension();

        $track = new Track();

        $track->filename = $track->getFilename($extension);
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

        return $track;
    }

    /**
     * trackがstore成功してartworkがstore失敗する状態は許容する
     * trackがstore失敗してartworkがstore成功する状態は許容しない
     */
    public static function storeTrackWithArtwork(StoreTrackWithArtwork $request)
    {
        $track = self::storeTrack($request);

        Artwork::storeArtwork($request, $track);
    }

    public static function deleteTrack(Track $track)
    {
        $artwork = $track->artwork;

        $track->delete();
        Storage::cloud()->delete([$track->filename, $artwork->filename]);
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

    public static function searchTracks($keyword)
    {
        return Track::with(['artist', 'artwork'])
            ->LikeSearch($keyword, 'title')
            ->latest()
            ->get();
    }
}
