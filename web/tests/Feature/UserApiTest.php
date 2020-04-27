<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class UserApiTest extends TestCase
{
  use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function should_return_authenticated_user()
    {
        $response = $this->actingAs($this->user)->json('GET', route('user'));

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => $this->user->name,
            ]);
    }

    /**
     * @test
     */
    public function should_return_empty_string()
    {
        $response = $this->json('GET', route('user'));

        $response->assertStatus(200);
        $this->assertEquals("", $response->content());
    }
}
