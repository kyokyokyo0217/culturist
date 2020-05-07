<?php

namespace Tests\Feature;

use App\User;
use App\ProfilePicture;
use App\CoverPhoto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SaveUserProfileChangesApiTest extends TestCase
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
   public function should_update_changes()
   {
     Storage::fake('s3');

    // ""で囲む
     $response = $this->actingAs($this->user)
         ->putJson("api/users/{$this->user->user_name}", [
             'cover_photo' => UploadedFile::fake()->image('coveer.jpg'),
             'profile_picture' => UploadedFile::fake()->image('profile.jpg'),
             'bio' => 'dumybio',
             'location' => 'dumylocation'
         ]);
     $response->assertStatus(204);

     $this->assertDatabaseHas('users', ['bio' => 'dumybio', 'location' => 'dumylocation']);

     $cover_photo = CoverPhoto::first();
     $this->assertRegExp('/^[0-9a-zA-Z-_]{12}$/', $cover_photo->id);
     Storage::cloud()->assertExists($cover_photo->filename);

     $profile_picture = ProfilePicture::first();
     $this->assertRegExp('/^[0-9a-zA-Z-_]{12}$/', $profile_picture->id);
     Storage::cloud()->assertExists($profile_picture->filename);
   }
}
