<?php

namespace Tests\Feature;

use App\Track;
use App\Artwork;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreTrackApiTest extends TestCase
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
     public function should_upload_file(): void
     {
         Storage::fake('s3');

         $response = $this->actingAs($this->user)
             ->postJson('api/tracks', [
                 'track' => UploadedFile::fake()->create('audio.mp3'),
                 'artwork' => UploadedFile::fake()->image('artwork.jpg'),
                 'title' => 'untitled'
             ]);
         $response->assertStatus(201);

         $track = Track::first();
         $this->assertRegExp('/^[0-9a-zA-Z-_]{12}$/', $track->id);
         $this->assertDatabaseHas('tracks', ['title' => 'untitled']);
         Storage::cloud()->assertExists($track->filename);

         $artwork = Artwork::first();
         $this->assertRegExp('/^[0-9a-zA-Z-_]{12}$/', $artwork->id);
         Storage::cloud()->assertExists($artwork->filename);

     }

     /**
      * @test
      */
     public function should_not_store_file_in_case_of_DBerror(): void
     {
         Schema::drop('tracks');

         Storage::fake('s3');

         $response = $this->actingAs($this->user)
             ->postJson('api/tracks', [
                 'track' => UploadedFile::fake()->create('audio.mp3'),
                 'artwork' => UploadedFile::fake()->image('artwork.jpg'),
                 'title' => 'untitled'
             ]);

         $response->assertStatus(500);

         $this->assertEquals(0, count(Storage::cloud()->files()));
     }

     /**
      * @test
      */
     public function should_not_insert_file_to_DB_in_case_of_storeerror(): void
     {
         Storage::shouldReceive('cloud')
             ->once()
             ->andReturnNull();

         $response = $this->actingAs($this->user)
             ->postJson('api/tracks', [
                 'track' => UploadedFile::fake()->create('audio.mp3'),
                 'artwork' => UploadedFile::fake()->image('artwork.jpg'),
                 'title' => 'untitled'
             ]);

         $response->assertStatus(500);

         $this->assertEmpty(Track::all());
         $this->assertEmpty(Artwork::all());
     }
}
