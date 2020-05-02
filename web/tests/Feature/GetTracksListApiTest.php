<?php

namespace Tests\Feature;

use App\User;
use App\Track;
use App\Artwork;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GetTracksListApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_response_json_correctly()
    {
        // factory(Track::class, 5)->create();
        factory(Artwork::class, 5)->create();
        $response = $this->getJson('/api/tracks');

        // pagination使う場合
        $tracks = Track::with(['artist', 'artwork'])->orderBy('created_at', 'desc')->get();
        $expected_data = $tracks->map(function ($track) {
            return [
                'id' => $track->id,
                'url' => $track->url,
                'title' => $track->title,
                'artist' => [
                  'name' => $track->artist->name,
                  'user_name' => $track->artist->user_name
                ],
                'artwork' => [
                  'id' => $track->artwork->id,
                  'url' => $track->artwork->url,
                ],
            ];
        })
        ->all();

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonFragment([
                'data' => $expected_data,
            ]);
    }
}
