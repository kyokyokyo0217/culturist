<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\ProfilePicture;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();

        $this->userWithProfilePicture = factory(User::class)->create();
        $this->userWithProfilePicture->profile_picture()->save(factory(ProfilePicture::class)->make());
    }

    /**
     * @test
     */
    public function should_return_authenticated_user(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/auth/user');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $this->user->name,
                    'user_name' => $this->user->user_name,
                ]
            ]);
    }

    /**
     * @test
     */
    public function should_return_authenticated_user_with_profile_picture(): void
    {
        $response = $this->actingAs($this->userWithProfilePicture)->getJson('/api/auth/user');

        // 長い！！
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $this->userWithProfilePicture->name,
                    'user_name' => $this->userWithProfilePicture->user_name,
                    'profile_picture' => [
                        'id' => $this->userWithProfilePicture->profile_picture->id,
                        'url' => $this->userWithProfilePicture->profile_picture->url,
                        'filename' => $this->userWithProfilePicture->profile_picture->filename
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function should_return_empty_string(): void
    {
        $response = $this->getJson('/api/auth/user');

        $response->assertStatus(200);
        $this->assertEquals("", $response->content());
    }
}
