<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutApiTest extends TestCase
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
    public function should_make_authenticated_user_logout(): void
    {
        $response = $this->actingAs($this->user)
            ->json('POST', route('logout'));

        $response->assertStatus(200);
        $this->assertGuest();
    }
}
