<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SoundCollection;
use App\Models\Sound;
use Illuminate\Http\Request;

class SoundController extends BaseController
{
    public function index(int $level_id)
    {
        $sounds = Sound::where('level_id', $level_id)->get();
        return $this->withSuccess(new SoundCollection($sounds));
    }
}
