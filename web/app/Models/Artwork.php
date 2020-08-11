<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Traits\StringKey;
use App\Traits\UrlAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Artwork extends Model
{
    use StringKey;
    use UrlAttribute;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $appends = [
        'url',
    ];

    protected $visible = [
        'id', 'url'
    ];

    protected $fillable = [
        'track_id'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!Arr::get($this->attributes, 'id')) {
            $this->setStringId($attributes);
        }
    }

    public function getUrlAttribute()
    {
        return $this->setUrlAttribute();
    }

    public static function storeArtwork(Request $request, Track $track)
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
    }
}
