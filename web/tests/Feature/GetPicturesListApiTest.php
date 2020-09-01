<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Picture;
use App\Models\ProfilePicture;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Crabon;

class GetPicturesListApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        factory(User::class, 5)->create()->each(function (User $user) {
            factory(Picture::class)->create(['user_id' => $user->id]);
            $user->profile_picture()->save(factory(ProfilePicture::class)->make());
        });

        $this->authUser = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function should_get_new_pictures(): void
    {
        $response = $this->getJson('/api/pictures/explore');

        $pictures = Picture::with(['artist', 'artist.profile_picture'])
            ->latest()
            ->paginate();

        $expected_data = $pictures->map(function ($picture) {
            return [
                'id' => $picture->id,
                'url' => $picture->url,
                'title' => $picture->title,
                'liked_by_user' => $picture->liked_by_user,
                'artist' => [
                    'name' => $picture->artist->name,
                    'user_name' => $picture->artist->user_name,
                    'bio' => $picture->artist->bio,
                    'location' => $picture->artist->location,
                    'followed_by_user' => $picture->artist->followed_by_user,
                    'created_at' => $picture->artist->created_at->format('Y/m/d'),
                    'profile_picture' => [
                        'id' => $picture->artist->profile_picture->id,
                        'url' => $picture->artist->profile_picture->url,
                    ]
                ],
            ];
        })
            ->all();

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonFragment([
                'data' => $expected_data,
            ]);
    }

    /**
     * @test
     */
    public function should_get_feed_pictures(): void
    {
        $followedUsers = User::all()->take(3);

        $followedUsers->each(function (User $user) {
            $this->actingAs($this->authUser)->postJson("/api/{$user->user_name}/follow");
        });

        $this->assertEquals(3, $this->authUser->follows()->count());

        $response = $this->getJson('/api/pictures/feed');

        $pictures = Picture::with(['artist', 'artist.profile_picture'])
            ->whereIn('user_id', $this->authUser->follows()->get()->modelkeys())
            ->latest()
            ->paginate();

        $expected_data = $pictures->map(function ($picture) {
            return [
                'id' => $picture->id,
                'url' => $picture->url,
                'title' => $picture->title,
                'liked_by_user' => $picture->liked_by_user,
                'artist' => [
                    'name' => $picture->artist->name,
                    'user_name' => $picture->artist->user_name,
                    'bio' => $picture->artist->bio,
                    'location' => $picture->artist->location,
                    'followed_by_user' => $picture->artist->followed_by_user,
                    'created_at' => $picture->artist->created_at->format('Y/m/d'),
                    'profile_picture' => [
                        'id' => $picture->artist->profile_picture->id,
                        'url' => $picture->artist->profile_picture->url,
                    ]
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
    public function should_get_liked_pictures(): void
    {
        $likedPictures = Picture::all()->take(3);

        $likedPictures->each(function (Picture $picture) {
            $this->actingAs($this->authUser)
                ->postJson("api/picture/{$picture->id}/like");
        });

        $this->assertEquals(3, $this->authUser->picture_likes()->count());

        $response = $this->getJson('/api/pictures/likes');

        $pictures = $this->authUser
            ->picture_likes()
            ->with(['artist', 'artist.profile_picture'])
            ->latest()
            ->paginate();

        $expected_data = $pictures->map(function ($picture) {
            return [
                'id' => $picture->id,
                'url' => $picture->url,
                'title' => $picture->title,
                'liked_by_user' => $picture->liked_by_user,
                'artist' => [
                    'name' => $picture->artist->name,
                    'user_name' => $picture->artist->user_name,
                    'bio' => $picture->artist->bio,
                    'location' => $picture->artist->location,
                    'followed_by_user' => $picture->artist->followed_by_user,
                    'created_at' => $picture->artist->created_at->format('Y/m/d'),
                    'profile_picture' => [
                        'id' => $picture->artist->profile_picture->id,
                        'url' => $picture->artist->profile_picture->url,
                    ]
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
    public function should_get_user_pictures(): void
    {
        $user = User::first();

        $response = $this->getJson("/api/pictures/user/{$user->user_name}");

        $pictures = Picture::with(['artist', 'artist.profile_picture'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate();

        $expected_data = $pictures->map(function ($picture) {
            return [
                'id' => $picture->id,
                'url' => $picture->url,
                'title' => $picture->title,
                'liked_by_user' => $picture->liked_by_user,
                'artist' => [
                    'name' => $picture->artist->name,
                    'user_name' => $picture->artist->user_name,
                    'bio' => $picture->artist->bio,
                    'location' => $picture->artist->location,
                    'followed_by_user' => $picture->artist->followed_by_user,
                    'created_at' => $picture->artist->created_at->format('Y/m/d'),
                    'profile_picture' => [
                        'id' => $picture->artist->profile_picture->id,
                        'url' => $picture->artist->profile_picture->url,
                    ]
                ],
            ];
        })
            ->all();

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment([
                'data' => $expected_data,
            ]);
    }
}
