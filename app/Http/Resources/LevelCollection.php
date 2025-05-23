<?php

namespace App\Http\Resources;

use App\Models\Level;
use App\Models\LevelProgress;
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
                'id' => $level->id,
                'name' => $level->name,
                'completed_sounds_to_success' => $level->completed_sounds_to_success,
                'letter' => new LetterResource($level->letter),
                'progress' => $level->letterProgress ? new LevelProgressResource($level->letterProgress) : [
                    'progress' => 0,
                    'sounds_count' => $level->sounds()->count(),
                    'completed_sounds_count' => 0,
                    'last_completed_sound_date' => null,
                    'status' => 0,
                ],
                'locked' => $this->isLocked($level),
                'sort_order' => $level->sort_order,
            ]
        )->toArray();
    }

    private function isLocked($level)
    {
        $previous_level_id = $level->letterProgress?->previous_level_id;

        if (!$previous_level_id) {
            return false;
        }

        $previousLevelProgress = LevelProgress::where('level_id', $previous_level_id)
            ->where('trainee_id', auth()->user()->id)
            ->first();

        if ($previousLevelProgress?->status === 'completed') {
            return false;
        }
        return true;
    }
}
