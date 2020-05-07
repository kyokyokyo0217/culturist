<?php

namespace App\Http\Controllers;

use App\User;
use App\CoverPhoto;
use App\ProfilePicture;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
      return $user->load('profile_picture', 'cover_photo');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateUserProfile $request, User $user)
    {
        $user->fill([
            'bio' => $request->bio,
            'location' => $request->location
        ])->save();


        $current_profile_piture = ProfilePicture::firstWhere('user_id', $user->id);

        if($current_profile_piture){

            Storage::cloud()->delete($current_profile_piture->filename);

            DB::beginTransaction();

            try {
                $current_profile_piture->delete();
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                Storage::cloud()
                    ->putFileAs('', $current_profile_piture, $current_profile_piture->filename, 'public');
            }
        }

        $profile_picture = new ProfilePicture();
        $profile_extension = $request->profile_picture->extension();
        $profile_picture->filename = $profile_picture->id . '.' . $profile_extension;
        Storage::cloud()
            ->putFileAs('', $request->profile_picture, $profile_picture->filename, 'public');

        DB::beginTransaction();

        try {
            $user->profile_picture()->save($profile_picture);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Storage::cloud()->delete($profile_picture->filename);
            throw $exception;
        }


        $current_cover_photo = CoverPhoto::firstWhere('user_id', $user->id);

        if($current_cover_photo){

            Storage::cloud()->delete($current_cover_photo->filename);

            DB::beginTransaction();

            try {
                $current_cover_photo->delete();
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                Storage::cloud()
                    ->putFileAs('', $current_cover_photo, $current_cover_photo->filename, 'public');
            }
        }

        $cover_photo = new CoverPhoto();
        $cover_extension = $request->cover_photo->extension();
        $cover_photo->filename = $cover_photo->id . '.' . $cover_extension;

        Storage::cloud()
            ->putFileAs('', $request->cover_photo, $cover_photo->filename, 'public');

        DB::beginTransaction();

        try {
            $user->cover_photo()->save($cover_photo);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Storage::cloud()->delete($cover_photo->filename);
            throw $exception;
        }

        return response('', 204);

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
