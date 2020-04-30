<?php

namespace Tests\Feature;

use App\Picture;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GetPictureListApiTest extends TestCase
{
  use RefreshDatabase;

  /**
   * @test
   */
  public function should_response_json_correctly()
  {
      factory(Picture::class, 5)->create();
      $response = $this->getJson('/api/pictures');

      // pagination使う場合
      $pictures = Picture::with(['artist'])->orderBy('created_at', 'desc')->get();
      $expected_data = $pictures->map(function ($picture) {
          return [
              'id' => $picture->id,
              'url' => $picture->url,
              'title' => $picture->title,
              'artist' => [
                  'name' => $picture->artist->name,
                  'user_name' => $picture->artist->user_name
              ],
          ];
      })
      ->all();

      $response->assertStatus(200)
          ->assertJsonCount(5, 'data')
          ->assertJsonFragment([
              'data' => $expected_data,
          ]);
      // $response->assertJsonStructure([
      //   'id',
      //   'url',
      //   'artist' => [
      //     'name'
      //   ],
      // ]);
  }
}
