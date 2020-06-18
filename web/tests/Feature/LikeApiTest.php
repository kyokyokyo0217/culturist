<?php

namespace Tests\Feature;

use App\Picture;
use App\Track;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        factory(Picture::class)->create();
        $this->picture = Picture::first();

        factory(Track::class)->create();
        $this->track = Track::first();
    }

    /**
     * @test
     */
    public function should_like_picture()
    {
        $response = $this->actingAs($this->user)
            ->postJson("api/picture/{$this->picture->id}/like");

        $response->assertStatus(201);

        $this->assertEquals(1, $this->picture->picture_liked_by()->count());
    }

    /**
     * @test
     */
    public function should_like_picture_only_once()
    {
        $param = $this->picture->id;
        $this->actingAs($this->user)->postJson("api/picture/{$param}/like");
        $this->actingAs($this->user)->postJson("api/picture/{$param}/like");

        $this->assertEquals(1, $this->picture->picture_liked_by()->count());
    }

    /**
     * @test
     */
    public function should_unlike_picture()
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
    public function should_like_track()
    {
        $response = $this->actingAs($this->user)
            ->postJson("api/track/{$this->track->id}/like");

        $response->assertStatus(201);

        $this->assertEquals(1, $this->track->track_liked_by()->count());
    }

    /**
     * @test
     */
    public function should_like_track_only_once()
    {
        $param = $this->track->id;
        $this->actingAs($this->user)->postJson("api/track/{$param}/like");
        $this->actingAs($this->user)->postJson("api/track/{$param}/like");

        $this->assertEquals(1, $this->track->track_liked_by()->count());
    }

    /**
     * @test
     */
    public function should_unlike_track()
    {
        $this->track->track_liked_by()->attach($this->user->id);

        $response = $this->actingAs($this->user)
            ->deleteJson("api/track/{$this->track->id}/like");

        $response->assertStatus(204);

        $this->assertEquals(0, $this->track->track_liked_by()->count());
    }
}
