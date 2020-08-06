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
        $pictures = Picture::with(['artist', 'artist.profile_picture'])
            ->orderBy(Picture::CREATED_AT, 'desc')
            ->paginate();

        return $pictures;
    }

    public function getPicturesFeed()
    {
        $pictures = Picture::whereHas('artist', function (Builder $query) {
            $query->whereIn('id', Auth::user()->follows()->get()->modelKeys());
        })->with(['artist', 'artist.profile_picture'])
            ->orderBy(Picture::CREATED_AT, 'desc')
            ->paginate();

        return $pictures;
    }

    public function getLikedPictures()
    {
        $pictures = Picture::whereHas('picture_liked_by', function (Builder $query) {
            $query->where('id', Auth::id());
        })->with(['artist', 'artist.profile_picture'])
            ->orderBy(Picture::CREATED_AT, 'desc')
            ->paginate();

        return $pictures;
    }

    public function getUserProfilePictures(User $user)
    {
        $pictures = Picture::with(['artist', 'artist.profile_picture'])
            ->where('user_id', $user->id)
            ->orderBy(Picture::CREATED_AT, 'desc')
            ->paginate();

        // $pictures = Picture::whereHas('artist', function (Builder $query) use($user){
        //     $query->where('id', $user->id);
        // })->with(['artist', 'artist.profile_picture'])
        //   ->orderBy(Picture::CREATED_AT, 'desc')
        //   ->paginate();

        return $pictures;
    }

    /**
     * Store a newly created resouce in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePicture $request)
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

        return response($picture, 201);
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

        return response('', 204);
    }
}
