<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CurrentProgress;
use App\Http\Resources\RatingResource;
use App\Models\Rating;

class RatingController extends BaseController
{
    public function index(int $sound_id = null)
    {
        // Rating::create([
        //     'sound_id' => 1,
        //     'trainee_id' => 1,
        //     'level_id' => 2,
        //     'failure_attempts' => 2,
        //     'success_attempts' => 8,
        //     'degree' => 80,
        //     'records' => [
        //         ['path' => '', 'type' => 'success', 'date' => now()->format('Y-m-d H:i')]
        //     ]
        //     ]);
        $ratings = Rating::where('trainee_id', auth()->user()->id)->when($sound_id, fn($q) => $q->where('sound_id', $sound_id))->get();
        $lists = RatingResource::collection($ratings);

        return $this->withSuccess($lists);
    }

    public function currentProgress()
    {
        return CurrentProgress::collection(Rating::where('trainee_id', auth()->user()->id)->get());
    }
}
