<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWork;
use App\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WorkController extends Controller
{
  public function __construct()
  {
      // 認証が必要
      $this->middleware('auth');
  }

  public function create(StoreWork $request)
  {
    $extension = $request->work->extension();

    $work = new Work();

    $work->filename = $work->id . '.' . $extension;

    $work->type = 'music';

    Storage::cloud()
        ->putFileAs('', $request->work, $work->filename, 'public');


    DB::beginTransaction();

    try {
        Auth::user()->works()->save($work);
        DB::commit();
    } catch (\Exception $exception) {
        DB::rollBack();
        Storage::cloud()->delete($work->filename);
        throw $exception;
    }

    return response($work, 201);
  }
}
