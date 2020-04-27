<?php

namespace Tests\Feature;

use App\Work;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhotoSubmitApiTest extends TestCase
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
    public function should_upload_file()
    {
        Storage::fake('s3');

        $response = $this->actingAs($this->user)
            ->json('POST', route('work.create'), [
                'photo' => UploadedFile::fake()->image('photo.jpg'),
            ]);

        $response->assertStatus(201);

        $photo = Work::first();

        $this->assertRegExp('/^[0-9a-zA-Z-_]{12}$/', $work->id);

        Storage::cloud()->assertExists($work->filename);
    }

    /**
     * @test
     */
    public function should_not_store_file_in_case_of_DBerror()
    {
        Schema::drop('works');

        Storage::fake('s3');

        $response = $this->actingAs($this->user)
            ->json('POST', route('work.create'), [
                'photo' => UploadedFile::fake()->image('photo.jpg'),
            ]);

        $response->assertStatus(500);

        $this->assertEquals(0, count(Storage::cloud()->files()));
    }

    /**
     * @test
     */
    public function should_not_insert_file_to_DB_in_case_of_storeerror()
    {
        Storage::shouldReceive('cloud')
            ->once()
            ->andReturnNull();

        $response = $this->actingAs($this->user)
            ->json('POST', route('work.create'), [
                'photo' => UploadedFile::fake()->image('photo.jpg'),
            ]);

        $response->assertStatus(500);

        $this->assertEmpty(Work::all());
    }
}
