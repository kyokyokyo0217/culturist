<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Track;
use App\Models\Artwork;
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
        return Track::getNewTracks();
    }

    public function getFeedTracks()
    {
        return Track::getFeedTracks();
    }

    public function getLikedTracks()
    {
        return Track::getLikedTracks();
    }

    public function getUserTracks(User $user)
    {
        return Track::getUserTracks($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrack $request)
    {
        Track::storeTrack($request);
        return response('', 201);
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
        Track::deleteTrack($track);
        return response('', 204);
    }
}
