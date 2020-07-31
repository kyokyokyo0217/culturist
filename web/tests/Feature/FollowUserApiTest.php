<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class FollowUserApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->authUser = factory(User::class)->create();
        $this->followedUser = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function should_follow_user(): void
    {
        $response = $this->actingAs($this->authUser)
            ->postJson("/api/{$this->followedUser->user_name}/follow");

        $response->assertStatus(201);

        $this->assertEquals(1, $this->followedUser->followers()->count());
    }

    /**
     * @test
     */
    public function should_follow_user_only_once(): void
    {
        $param = $this->followedUser->user_name;
        $this->actingAs($this->authUser)->postJson("api/{$param}/follow");
        $this->actingAs($this->authUser)->postJson("api/{$param}/follow");

        $this->assertEquals(1, $this->followedUser->followers()->count());
    }

    /**
     * @test
     */
    public function should_unfollow_user(): void
    {
        $this->followedUser->followers()->attach($this->authUser->id);

        $response = $this->actingAs($this->authUser)
            ->deleteJson("/api/{$this->followedUser->user_name}/follow");

        $response->assertStatus(204);

        $this->assertEquals(0, $this->followedUser->followers()->count());
    }
}
