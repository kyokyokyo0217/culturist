<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Track;
use App\Models\Artwork;

class DeleteTrackApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_delete_track(): void
    {
        factory(User::class)->create()->each(function (User $user) {
            factory(Track::class)->create(['user_id' => $user->id])->each(function (Track $track) {
                factory(Artwork::class)->create(['track_id' => $track->id]);
            });
        });

        $user = User::first();
        $track = Track::first();

        $response = $this->actingAs($user)
            ->deleteJson("api/tracks/{$track->id}");

        $response->dump();

        $response->assertStatus(204);

        $this->assertCount(0, Track::all());
        $this->assertCount(0, Artwork::all());
    }
}
