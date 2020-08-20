<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Track;
use App\Models\Artwork;
use App\Models\ProfilePicture;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class getTracksListApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        factory(User::class, 5)->create()->each(function (User $user) {
            factory(Track::class)->create(['user_id' => $user->id])->each(function (Track $track) {
                factory(Artwork::class)->create(['track_id' => $track->id]);
            });
            $user->profile_picture()->save(factory(ProfilePicture::class)->make());
        });

        $this->authUser = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function should_get_new_tracks(): void
    {
        $response = $this->getJson('/api/tracks/explore');

        $tracks = Track::with(['artist', 'artwork'])
            ->latest()
            ->get();

        $expected_data = $tracks->map(function ($track) {
            return [
                'id' => $track->id,
                'url' => $track->url,
                'title' => $track->title,
                'liked_by_user' => $track->liked_by_user,
                'artist' => [
                    'name' => $track->artist->name,
                    'user_name' => $track->artist->user_name,
                    'bio' => $track->artist->bio,
                    'location' => $track->artist->location,
                    'followed_by_user' => $track->artist->followed_by_user,
                    'created_at' => $track->artist->created_at->format('Y/m/d')
                ],
                'artwork' => [
                    'id' => $track->artwork->id,
                    'url' => $track->artwork->url,
                ]
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
    public function should_get_feed_tracks(): void
    {
        $followedUsers = User::all()->take(3);

        $followedUsers->each(function (User $user) {
            $this->actingAs($this->authUser)->postJson("/api/{$user->user_name}/follow");
        });

        $this->assertEquals(3, $this->authUser->follows()->count());


        $response = $this->getJson('/api/tracks/feed');

        $tracks = Track::whereHas('artist', function (Builder $query) {
            $query->whereIn('id', $this->authUser->follows()->get()->modelKeys());
        })->with(['artist', 'artwork'])
            ->latest()
            ->get();

        $expected_data = $tracks->map(function ($track) {
            return [
                'id' => $track->id,
                'url' => $track->url,
                'title' => $track->title,
                'liked_by_user' => $track->liked_by_user,
                'artist' => [
                    'name' => $track->artist->name,
                    'user_name' => $track->artist->user_name,
                    'bio' => $track->artist->bio,
                    'location' => $track->artist->location,
                    'followed_by_user' => $track->artist->followed_by_user,
                    'created_at' => $track->artist->created_at->format('Y/m/d')
                ],
                'artwork' => [
                    'id' => $track->artwork->id,
                    'url' => $track->artwork->url,
                ]
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
    public function should_get_liked_tracks(): void
    {
        $likedTracks = Track::all()->take(3);

        $likedTracks->each(function (Track $track) {
            $this->actingAs($this->authUser)
                ->postJson("api/track/{$track->id}/like");
        });

        $response = $this->getJson('/api/tracks/likes');

        $tracks = $this->authUser
            ->track_likes()
            ->with(['artist', 'artwork'])
            ->latest()
            ->paginate();

        $expected_data = $tracks->map(function ($track) {
            return [
                'id' => $track->id,
                'url' => $track->url,
                'title' => $track->title,
                'liked_by_user' => $track->liked_by_user,
                'artist' => [
                    'name' => $track->artist->name,
                    'user_name' => $track->artist->user_name,
                    'bio' => $track->artist->bio,
                    'location' => $track->artist->location,
                    'followed_by_user' => $track->artist->followed_by_user,
                    'created_at' => $track->artist->created_at->format('Y/m/d')
                ],
                'artwork' => [
                    'id' => $track->artwork->id,
                    'url' => $track->artwork->url,
                ]
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
    public function should_get_user_profile_pictures(): void
    {
        $user = User::first();

        $response = $this->getJson("/api/tracks/user/{$user->user_name}");

        $tracks = Track::with(['artist', 'artwork'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $expected_data = $tracks->map(function ($track) {
            return [
                'id' => $track->id,
                'url' => $track->url,
                'title' => $track->title,
                'liked_by_user' => $track->liked_by_user,
                'artist' => [
                    'name' => $track->artist->name,
                    'user_name' => $track->artist->user_name,
                    'bio' => $track->artist->bio,
                    'location' => $track->artist->location,
                    'followed_by_user' => $track->artist->followed_by_user,
                    'created_at' => $track->artist->created_at->format('Y/m/d')
                ],
                'artwork' => [
                    'id' => $track->artwork->id,
                    'url' => $track->artwork->url,
                ]
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
