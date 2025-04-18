<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CurrentProgress;
use App\Http\Resources\SoundProgressResource;
use App\Models\SoundProgress;

class SoundProgressController extends BaseController
{
    public function index(int $sound_id)
    {
        $rating = SoundProgress::where('trainee_id', auth()->user()->id)->where('sound_id', $sound_id)->first();
        if(!$rating) {
            return $this->withError('هذا الصوت غير موجود', 404);
        }
        $lists = new SoundProgressResource($rating);

        return $this->withSuccess($lists);
    }

    public function currentProgress()
    {
        return CurrentProgress::collection(SoundProgress::where('trainee_id', auth()->user()->id)->get());
    }
}
