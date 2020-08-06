<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\ProfilePicture;
use App\Models\CoverPhoto;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class GetUserProfileApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        factory(User::class)->create()->each(function (User $user) {
            factory(ProfilePicture::class)->create(['user_id' => $user->id]);
            factory(CoverPhoto::class)->create(['user_id' => $user->id]);
        });
    }

    /**
     * @test
     */
    public function should_return_user_profile(): void
    {
        $user = User::with(['profile_picture', 'cover_photo'])->first();

        $response = $this->getJson("/api/users/{$user->user_name}");

        // dataでラップしてない
        $response->assertStatus(200)
            ->assertJson([
                'name' => $user->name,
                'user_name' => $user->user_name,
                'bio' => $user->bio,
                'location' => $user->location,
                'followed_by_user' => $user->followed_by_user,
                'created_at' => $user->created_at->format('Y/m/d'),
                'profile_picture' => [
                    'id' => $user->profile_picture->id,
                    'url' => $user->profile_picture->url,
                    'filename' => $user->profile_picture->filename
                ],
                'cover_photo' => [
                    'id' => $user->cover_photo->id,
                    'url' => $user->cover_photo->url,
                    'filename' => $user->cover_photo->filename
                ]
            ]);
    }
}
