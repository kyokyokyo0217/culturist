<?php

namespace App\Http\Controllers;

use App\Track;
use App\Http\Controllers\ArtworkController;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTrack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tracks = Track::with(['artist', 'artwork'])
            ->orderBy(Track::CREATED_AT, 'desc')->paginate();

        return $tracks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function destroy($id)
    {
        //
    }
}
