<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Picture;

class DeletePictureApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_delete_picture(): void
    {
        factory(User::class)->create()->each(function ($user) {
            factory(Picture::class)->create(['user_id' => $user->id]);
        });

        $user = User::first();
        $picture = Picture::first();

        $response = $this->actingAs($user)
            ->deleteJson("api/pictures/{$picture->id}");

        $response->assertStatus(204);

        $this->assertCount(0, Picture::all());
    }
}
