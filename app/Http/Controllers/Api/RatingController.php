<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CurrentProgress;
use App\Http\Resources\RatingResource;
use App\Models\Rating;

class RatingController extends BaseController
{
    public function index(int $sound_id)
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
        $rating = Rating::where('trainee_id', auth()->user()->id)->where('sound_id', $sound_id)->first();
        if(!$rating) {
            return $this->withError('هذا الصوت غير موجود', 404);
        }
        $lists = new RatingResource($rating);

        return $this->withSuccess($lists);
    }

    public function currentProgress()
    {
        return CurrentProgress::collection(Rating::where('trainee_id', auth()->user()->id)->get());
    }
}
