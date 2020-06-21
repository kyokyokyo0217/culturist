<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Picture;
use App\ProfilePicture;
use Illuminate\Database\Eloquent\Builder;

class getPicturesListApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
       parent::setUp();

       factory(User::class, 5)->create()->each(function (User $user){
           factory(Picture::class)->create(['user_id' => $user->id]);
           $user->profile_picture()->save(factory(ProfilePicture::class)->make());
       });

       $this->authUser = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function should_get_new_pictures() :void
    {
        $response = $this->getJson('/api/pictures/explore');

        $pictures = Picture::with(['artist', 'artist.profile_picture'])->orderBy('created_at', 'desc')->get();

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
                    'profile_picture' => [
                      'id' => $picture->artist->profile_picture->id,
                      'url' => $picture->artist->profile_picture->url,
                      'filename' => $picture->artist->profile_picture->filename
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
    public function should_get_feed_pictures() :void
    {
        $followedUsers = User::all()->take(3);

        $followedUsers->each(function (User $user) {
          $this->actingAs($this->authUser)->postJson("/api/{$user->user_name}/follow");
        });

        $this->assertEquals(3, $this->authUser->follows()->count());


        $response = $this->getJson('/api/pictures/feed');

        $pictures = Picture::whereHas('artist', function(Builder $query) {
            $query->whereIn('id', $this->authUser->follows()->get()->modelKeys());
        })->with(['artist', 'artist.profile_picture'])
          ->orderBy(Picture::CREATED_AT, 'desc')
          ->get();

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
                    'profile_picture' => [
                      'id' => $picture->artist->profile_picture->id,
                      'url' => $picture->artist->profile_picture->url,
                      'filename' => $picture->artist->profile_picture->filename
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
    public function should_get_liked_pictures() :void
    {
        $likedPictures = Picture::all()->take(3);

        $likedPictures->each(function (Picture $picture) {
          $this->actingAs($this->authUser)
              ->postJson("api/picture/{$picture->id}/like");
        });

        // $this->assertEquals(3, $this->authUser->picture_likes()->count());

        $response = $this->getJson('/api/pictures/likes');

        $pictures = Picture::whereHas('picture_liked_by', function (Builder $query) {
            $query->where('id', $this->authUser->id);
        })->with(['artist', 'artist.profile_picture'])
          ->orderBy(Picture::CREATED_AT, 'desc')
          ->get();

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
                    'profile_picture' => [
                      'id' => $picture->artist->profile_picture->id,
                      'url' => $picture->artist->profile_picture->url,
                      'filename' => $picture->artist->profile_picture->filename
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
     public function should_get_user_profile_pictures() :void
     {
        $user = User::first();

        $response = $this->getJson("/api/pictures/user/{$user->user_name}");

        $pictures = Picture::with(['artist', 'artist.profile_picture'])
              ->where('user_id', $user->id)
              ->orderBy(Picture::CREATED_AT, 'desc')
              ->get();

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
                    'profile_picture' => [
                      'id' => $picture->artist->profile_picture->id,
                      'url' => $picture->artist->profile_picture->url,
                      'filename' => $picture->artist->profile_picture->filename
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
