<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class DeleteUserApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_delete_user(): void
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->deleteJson("api/users/{$user->user_name}");

        $response->assertStatus(204);

        $this->assertCount(0, User::all());
    }
}
