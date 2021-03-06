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
use App\Traits\LikeSearchScope;

class User extends Authenticatable
{
    use Notifiable;
    use LikeSearchScope;

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

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'user_name';
    }

    /**
     * Accessor for 'followed_by_user'
     *
     * @return boolean
     */
    public function getFollowedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return $this->followers->contains(Auth::user());
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
        return $this->belongsToMany('App\Models\Picture', 'picture_likes', 'user_id', 'picture_id')->withTimestamps();
    }

    public function track_likes()
    {
        return $this->belongsToMany('App\Models\Track', 'track_likes', 'user_id', 'track_id')->withTimestamps();
    }

    public static function getFollowingUsers()
    {
        $users = Auth::user()
            ->follows()
            ->with('profile_picture')
            ->paginate();

        return $users;
    }

    public static function getFollowers()
    {
        $users = Auth::user()
            ->followers()
            ->with('profile_picture')
            ->paginate();

        return $users;
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
            ProfilePicture::updateProfilePicture($request, $user);
        }

        if ($request->hasFile('cover_photo')) {
            CoverPhoto::updateCoverPhoto($request, $user);
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

    public static function searchUsers($keyword)
    {
        return User::with(['profile_picture'])
            ->LikeSearch($keyword, 'name')
            ->orWhere
            ->LikeSearch($keyword, 'user_name')
            ->latest()
            ->get();
    }
}
