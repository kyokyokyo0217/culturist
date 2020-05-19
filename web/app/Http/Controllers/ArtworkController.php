<?php

namespace App\Http\Controllers;

use App\Artwork;
use App\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
      public function __construct()
      {
          $this->middleware('auth');
      }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Track $track)
    {
      $extension = $request->artwork->extension();

      $artwork = new Artwork();

      $artwork->filename = $artwork->id . '.' . $extension;

      Storage::cloud()
          ->putFileAs('', $request->artwork, $artwork->filename, 'public');


      DB::beginTransaction();

      try {
          $track->artwork()->save($artwork);
          DB::commit();
      } catch (\Exception $exception) {
          DB::rollBack();
          Storage::cloud()->delete($artwork->filename);
          throw $exception;
      }

      return response($artwork, 201);
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
    public function destroy($id)
    {
        //
    }
}
