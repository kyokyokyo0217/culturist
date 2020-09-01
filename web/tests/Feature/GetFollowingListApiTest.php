<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\ProfilePicture;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Crabon;

class GetFollowingListApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();


        factory(User::class, 5)->create()->each(function (User $user) {
            $user->profile_picture()->save(factory(ProfilePicture::class)->make());
        });

        $this->authUser = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function should_get_following_list(): void
    {
        $followingUsers = User::all()->take(3);

        $followingUsers->each(function (User $user) {
            $this->actingAs($this->authUser)->postJson("/api/{$user->user_name}/follow");
        });

        $this->assertEquals(3, $this->authUser->follows()->count());

        $response = $this->actingAs($this->authUser)->getJson('/api/users/following');

        $users = $this->authUser
            ->follows()
            ->with(['profile_picture'])
            ->paginate();

        $expected_data = $users->map(function ($user) {
            return [
                'name' => $user->name,
                'user_name' => $user->user_name,
                'bio' => $user->bio,
                'location' => $user->location,
                'followed_by_user' => $user->followed_by_user,
                'created_at' => $user->created_at->format('Y/m/d'),
                'profile_picture' => [
                    'id' => $user->profile_picture->id,
                    'url' => $user->profile_picture->url,
                ],
            ];
        })
            ->all();

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonFragment([
                'data' => $expected_data,
            ]);
    }

    /**
     * @test
     */
    public function should_get_followers_list(): void
    {
        $followers = User::all()->take(3);

        $followers->each(function (User $user) {
            $this->actingAs($user)->postJson("/api/{$this->authUser->user_name}/follow");
        });

        $this->assertEquals(3, $this->authUser->followers()->count());

        $response = $this->actingAs($this->authUser)->getJson('/api/users/followers');

        $users = $this->authUser
            ->followers()
            ->with(['profile_picture'])
            ->paginate();

        $expected_data = $users->map(function ($user) {
            return [
                'name' => $user->name,
                'user_name' => $user->user_name,
                'bio' => $user->bio,
                'location' => $user->location,
                'followed_by_user' => $user->followed_by_user,
                'created_at' => $user->created_at->format('Y/m/d'),
                'profile_picture' => [
                    'id' => $user->profile_picture->id,
                    'url' => $user->profile_picture->url,
                ],
            ];
        })
            ->all();

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonFragment([
                'data' => $expected_data,
            ]);
    }
}
