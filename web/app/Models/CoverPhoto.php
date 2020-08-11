<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Traits\StringKey;
use App\Traits\UrlAttribute;
use App\Http\Requests\UpdateUserProfile;

class CoverPhoto extends Model
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

    public static function updateCoverPhoto(UpdateUserProfile $request, User $user)
    {
        $current_cover_photo = $user->cover_photo;

        if ($current_cover_photo) {
            $current_cover_photo->delete();
            Storage::cloud()->delete($current_cover_photo->filename);
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
