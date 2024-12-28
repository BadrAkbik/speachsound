<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AudioErrorsDetection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiModelController extends Controller
{
    public function upload_audio(Request $request)
    {
        $validated = $request->validate([
            'audio' => ['required', 'file', 'mimes:mp4,mp3,wav'],
            'correct_word' => ['required', 'string']
        ]);
        $response = Http::attach(
            'audio',
            file_get_contents($request->file('audio')),
            $request->file('audio')->getClientOriginalName()
        )->post('http://nanteq.net:8000/api/ai_analyser/', [
            'audio' => $request->file('audio')
        ]);

        /* explode() */
        if ($response->successful()) {

            $audio = new AudioErrorsDetection();
            $transcribedText = json_decode($response)->text;
            $audio->splitFilterText($transcribedText);

            return $this->sendResponse($audio->compareWords($validated['correct_word']), '', $response->status());
        } else {
            return $this->throw(__('api.Something went wrong, please try again'), $response->status());
        }
    }
}
