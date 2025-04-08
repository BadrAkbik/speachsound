<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LevelCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->transform(
            fn($level) =>
            [
                'name' => $level->name,
                'progress' => $level->rating(auth()->user()->id, $level->sound_id)->first()?->progress ?? 0 . '%',
                'attempt_to_success' => $level->attempt_to_success,
                'sound' => new SoundResource($level->sound)
            ]
        )->toArray();
    }
}
