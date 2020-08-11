<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Traits\StringKey;
use App\Traits\UrlAttribute;
use App\Http\Requests\UpdateUserProfile;


class ProfilePicture extends Model
{
    use StringKey;
    use UrlAttribute;

    protected $keyType = 'string';

    protected $appends = [
        'url',
    ];

    protected $visible = [
        'id', 'url', 'filename'
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

    public static function updateProfilePicture(UpdateUserProfile $request, User $user)
    {
        $current_profile_piture = $user->profile_picture;

        if ($current_profile_piture) {
            $current_profile_piture->delete();
            Storage::cloud()->delete($current_profile_piture->filename);
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
}
