<?php

namespace App\Models;

use App\Http\Requests\UpdateUserProfile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DateTimeInterface;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_name', 'email', 'password', 'bio', 'location'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $visible = [
        'name', 'user_name', 'pictures', 'tracks', 'bio', 'location', 'profile_picture', 'cover_photo', 'followed_by_user', 'created_at'
    ];

    protected $appends = [
        'followed_by_user'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // route binding のkey変える
    public function getRouteKeyName()
    {
        return 'user_name';
    }

    public function getFollowedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return $this->followers->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y/m/d');
    }

    public function pictures()
    {
        return $this->hasMany('App\Models\Picture');
    }

    public function tracks()
    {
        return $this->hasMany('App\Models\Track');
    }

    public function profile_picture()
    {
        return $this->hasOne('App\Models\ProfilePicture');
    }

    public function cover_photo()
    {
        return $this->hasOne('App\Models\CoverPhoto');
    }

    public function follows()
    {
        return $this->belongsToMany('App\Models\User', 'follows', 'follow_id', 'follower_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany('App\Models\User', 'follows', 'follower_id', 'follow_id')->withTimestamps();
    }

    public function picture_likes()
    {
        return $this->belongsToMany('App\Models\Picture', 'picture_likes', 'user_id', 'piture_id')->withTimestamps();
    }

    public function track_likes()
    {
        return $this->belongsToMany('App\Models\Track', 'track_likes', 'user_id', 'track_id')->withTimestamps();
    }

    public static function getUserProfile(User $user)
    {
        return $user->load('profile_picture', 'cover_photo');
    }

    public static function updateUserProfile(UpdateUserProfile $request, User $user)
    {
        $user->fill([
            'bio' => $request->bio,
            'location' => $request->location
        ])->save();

        if ($request->hasFile('profile_picture')) {

            $current_profile_piture = ProfilePicture::firstWhere('user_id', $user->id);

            if ($current_profile_piture) {

                Storage::cloud()->delete($current_profile_piture->filename);

                DB::beginTransaction();

                try {
                    $current_profile_piture->delete();
                    DB::commit();
                } catch (\Exception $exception) {
                    DB::rollBack();
                    Storage::cloud()
                        ->putFileAs('', $current_profile_piture, $current_profile_piture->filename, 'public');
                    throw $exception;
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
        }

        if ($request->hasFile('cover_photo')) {

            $current_cover_photo = CoverPhoto::firstWhere('user_id', $user->id);

            if ($current_cover_photo) {

                Storage::cloud()->delete($current_cover_photo->filename);

                DB::beginTransaction();

                try {
                    $current_cover_photo->delete();
                    DB::commit();
                } catch (\Exception $exception) {
                    DB::rollBack();
                    Storage::cloud()
                        ->putFileAs('', $current_cover_photo, $current_cover_photo->filename, 'public');
                    throw $exception;
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
        }
    }

    public static function deleteUser(User $user)
    {
        return $user->delete();
    }
    // public function deleteUser()
    // {
    //     return $this->delete();
    // }

    public static function followUser(User $user)
    {
        Auth::user()->follows()->detach($user->id);
        Auth::user()->follows()->attach($user->id);
    }

    public static function unfollowUser(User $user)
    {
        Auth::user()->follows()->detach($user->id);
    }
}
