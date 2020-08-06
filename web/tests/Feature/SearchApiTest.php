<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Picture;
use App\Models\Track;
use App\Models\Artwork;
use App\Models\User;
use App\Models\ProfilePicture;
use App\Models\CoverPhoto;

class SearchApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // fetchの対象
        factory(User::class)->create(['name' => 'dummy'])->each(function (User $user) {
            factory(Picture::class)->create(['title' => 'dummy', 'user_id' => $user->id]);
        });

        factory(User::class)->create(['user_name' => 'dummy'])->each(function (User $user) {
            factory(Track::class)->create(['title' => 'dummy', 'user_id' => $user->id])->each(function (Track $track) {
                factory(Artwork::class)->create(['track_id' => $track->id]);
            });
        });

        // fetchの対象外
        factory(User::class, 3)->create()->each(function (User $user) {
            factory(CoverPhoto::class)->create(['user_id' => $user->id]);
            factory(ProfilePicture::class)->create(['user_id' => $user->id]);
            factory(Picture::class, 3)->create(['user_id' => $user->id]);
            factory(Track::class, 3)->create(['user_id' => $user->id])->each(function (Track $track) {
                factory(Artwork::class)->create(['track_id' => $track->id]);
            });
        });
    }

    /**
     * @test
     */
    public function should_return_json_correctly(): void
    {
        $response = $this->postJson('/api/search', ['keyword' => 'dummy']);

        $response->assertStatus(200)
            ->assertJson([
                'users' => [['name' => 'dummy'], ['user_name' => 'dummy']],
                'pictures' => [['title' => 'dummy']],
                'tracks' => [['title' => 'dummy']]
            ]);
    }

    /**
     * @test
     */
    public function should_abort_404(): void
    {
        $response = $this->postJson('/api/search', ['keyword' => '']);

        $response->assertStatus(404);
    }
}
