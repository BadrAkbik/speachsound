<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\LetterCollection;
use App\Models\Letter;

class LetterController extends BaseController
{
    public function index()
    {
        $user_age_group = auth()->user()->ageGroup?->id;

        $letters = Letter::where('is_active', true)
            ->orderByRaw("age_group_id = ? DESC, id ASC", [$user_age_group])
            ->orderBy('id')
            ->get();

        return $this->withSuccess(new LetterCollection($letters));
    }
}
