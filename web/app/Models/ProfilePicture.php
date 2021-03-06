<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Traits\StringKey;
use App\Traits\UrlAttribute;
use App\Traits\Filename;
use App\Http\Requests\UpdateUserProfile;

class ProfilePicture extends Model
{
    use StringKey;
    use UrlAttribute;
    use Filename;

    protected $keyType = 'string';

    protected $appends = [
        'url',
    ];

    protected $visible = [
        'id', 'url'
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

    public static function storeProfilePicture($request, User $user)
    {
        $extension = $request->profile_picture->extension();

        $profile_picture = new ProfilePicture();
        $profile_picture->filename = $profile_picture->getFilename($extension);

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

        return $profile_picture;
    }

    public static function updateProfilePicture(UpdateUserProfile $request, User $user)
    {
        if ($user->profile_picture) {
            self::deleteProfilePicture($user->profile_picture);
        }

        self::storeProfilePicture($request, $user);
    }

    public static function deleteProfilePicture(ProfilePicture $profile_picture)
    {
        $profile_picture->delete();
        Storage::cloud()->delete($profile_picture->filename);
    }
}
