<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Requests\StorePicture;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class PictureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'destroy']);
    }

    public function getNewPictures()
    {
        return Picture::getNewPictures();
    }

    public function getFeedPictures()
    {
        return Picture::getFeedPictures();
    }

    public function getLikedPictures()
    {
        return Picture::getLikedPictures();
    }

    public function getUserPictures(User $user)
    {
        return Picture::getUserPictures($user);
    }

    /**
     * Store a newly created resouce in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePicture $request)
    {
        Picture::storePicture($request);
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
    public function destroy(Picture $picture)
    {
        Picture::deletePicture($picture);
        return response('', 204);
    }
}
