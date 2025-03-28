<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SoundCollection;
use App\Models\Sound;

class SoundController extends Controller
{
    public function index()
    {
        $user_age_group = auth()->user()->ageGroup?->id;

        $sounds = Sound::where('is_active', true)
            ->orderByRaw("age_group_id = ? DESC, id ASC", [$user_age_group])
            ->orderBy('id')
            ->get();

        return new SoundCollection($sounds);
    }
}
