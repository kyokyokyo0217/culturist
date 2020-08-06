<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Track;
use App\Artwork;
use App\Http\Controllers\ArtworkController;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTrack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

class TrackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'destroy']);
    }

    public function getNewTracks()
    {
        $tracks = Track::with(['artist', 'artwork'])
            ->orderBy(Track::CREATED_AT, 'desc')
            ->paginate();

        return $tracks;
    }

    // クエリ少なくしたい
    public function getTracksFeed()
    {
        $tracks = Track::whereHas('artist', function (Builder $query) {
            $query->whereIn('id', Auth::user()->follows()->get()->modelKeys());
        })->with(['artist', 'artwork'])
            ->orderBy(Track::CREATED_AT, 'desc')
            ->paginate();

        return $tracks;
    }

    public function getLikedTracks()
    {
        $tracks = Track::whereHas('track_liked_by', function (Builder $query) {
            $query->where('id', Auth::id());
        })->with(['artist', 'artwork'])
            ->orderBy(Track::CREATED_AT, 'desc')
            ->paginate();

        return $tracks;
    }

    public function getUserProfileTracks(User $user)
    {
        // $tracks = Track::whereHas('artist', function (Builder $query) use($user) {
        //     $query->where('id', $user->id);
        // })->with(['artist', 'artwork'])
        //   ->orderBy(Track::CREATED_AT, 'desc')
        //   ->paginate();

        $tracks = Track::with(['artist', 'artwork'])
            ->where('user_id', $user->id)
            ->orderBy(Track::CREATED_AT, 'desc')
            ->paginate();

        return $tracks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrack $request)
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

        $called = app()->make('App\Http\Controllers\ArtworkController');
        $response  = $called->store($request, $track);

        // return redirect()->route('artworks.store');

        // return Redirect::route("artworks.store");
        // return redirect()->action('ArtworkController@store');

        return response($track, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Track $track)
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

        return response('', 204);
    }
}
