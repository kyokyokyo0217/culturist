<?php

namespace Tests\Feature;

use App\Models\Picture;
use App\Models\Track;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        factory(User::class)->create()->each(function ($user) {
            factory(Picture::class)->create(['user_id' => $user->id]);
            factory(Track::class)->create(['user_id' => $user->id]);
        });

        $this->user = User::first();
        $this->picture = Picture::first();
        $this->track = Track::first();
    }

    /**
     * @test
     */
    public function should_like_picture(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson("api/picture/{$this->picture->id}/like");

        $response->assertStatus(201);

        $this->assertEquals(1, $this->picture->picture_liked_by()->count());
    }

    /**
     * @test
     */
    public function should_like_picture_only_once(): void
    {
        $param = $this->picture->id;
        $this->actingAs($this->user)->postJson("api/picture/{$param}/like");
        $this->actingAs($this->user)->postJson("api/picture/{$param}/like");

        $this->assertEquals(1, $this->picture->picture_liked_by()->count());
    }

    /**
     * @test
     */
    public function should_unlike_picture(): void
    {
        $this->picture->picture_liked_by()->attach($this->user->id);

        $response = $this->actingAs($this->user)
            ->deleteJson("api/picture/{$this->picture->id}/like");

        $response->assertStatus(204);

        $this->assertEquals(0, $this->picture->picture_liked_by()->count());
    }

    /**
     * @test
     */
    public function should_like_track(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson("api/track/{$this->track->id}/like");

        $response->assertStatus(201);

        $this->assertEquals(1, $this->track->track_liked_by()->count());
    }

    /**
     * @test
     */
    public function should_like_track_only_once(): void
    {
        $param = $this->track->id;
        $this->actingAs($this->user)->postJson("api/track/{$param}/like");
        $this->actingAs($this->user)->postJson("api/track/{$param}/like");

        $this->assertEquals(1, $this->track->track_liked_by()->count());
    }

    /**
     * @test
     */
    public function should_unlike_track(): void
    {
        $this->track->track_liked_by()->attach($this->user->id);

        $response = $this->actingAs($this->user)
            ->deleteJson("api/track/{$this->track->id}/like");

        $response->assertStatus(204);

        $this->assertEquals(0, $this->track->track_liked_by()->count());
    }
}
