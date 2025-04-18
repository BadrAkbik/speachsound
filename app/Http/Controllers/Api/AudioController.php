<?php

namespace App\Http\Controllers\Api;

use App\Services\AudioService;
use Illuminate\Http\Request;

class AudioController extends BaseController
{

    public function __construct(protected AudioService $audioService)
    {
    }

    public function assignSound(Request $request)
    {
        $validated = $request->validate([
            'audio' => ['required', 'file', 'mimes:mp4,mp3,wav'],
            'sound_id' => ['required', 'integer', 'exists:sounds,id'],
        ]);

        return $this->audioService->handle($validated);
    }
}
