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

class CoverPhoto extends Model
{
    use StringKey;
    use UrlAttribute;
    use Filename;

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

    public static function storeCoverPhoto($request, User $user)
    {
        $extension = $request->cover_photo->extension();

        $cover_photo = new CoverPhoto();
        $cover_photo->filename = $cover_photo->getFilename($request);

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

        return $cover_photo;
    }

    public static function updateCoverPhoto(UpdateUserProfile $request, User $user)
    {
        if ($user->cover_photo) {
            self::deleteCoverPhoto($user->cover_photo);
        }

        self::storeCoverPhoto($request, $user);
    }

    public static function deleteCoverPhoto(CoverPhoto $cover_photo)
    {
        $cover_photo->delete();
        Storage::cloud()->delete($cover_photo->filename);
    }
}
