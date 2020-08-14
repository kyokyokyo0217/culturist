<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ArtworkResource;

class TrackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'id' => $this->id,
            'url' => $this->url,
            'liked_by_user' => $this->liked_by_user,
            'artist' => new UserResource($this->artist),
            'artwork' => new ArtworkResource($this->artwork)
        ];
    }
}
