<?php

namespace Tests\Feature;

use App\Picture;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorePictureApiTest extends TestCase
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
            ->postJson('api/pictures', [
                'picture' => UploadedFile::fake()->image('photo.jpg'),
                'title' => 'untitled'
            ]);

        $response->assertStatus(201);

        $picture = Picture::first();

        $this->assertRegExp('/^[0-9a-zA-Z-_]{12}$/', $picture->id);

        // $this->assertExists($picture->title);

        $this->assertDatabaseHas('pictures', ['title' => 'untitled']);

        Storage::cloud()->assertExists($picture->filename);

    }

    /**
     * @test
     */
    public function should_not_store_file_in_case_of_DBerror(): void
    {
        Schema::drop('pictures');

        Storage::fake('s3');

        $response = $this->actingAs($this->user)
            ->postJson('api/pictures', [
                'picture' => UploadedFile::fake()->image('photo.jpg'),
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
            ->postJson('api/pictures', [
                'picture' => UploadedFile::fake()->image('photo.jpg'),
                'title' => 'untitled'
            ]);

        $response->assertStatus(500);

        $this->assertEmpty(Picture::all());
    }
}
