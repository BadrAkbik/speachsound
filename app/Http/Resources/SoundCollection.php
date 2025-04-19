<?php

namespace App\Http\Resources;

use App\Models\Level;
use App\Models\LevelProgress;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SoundCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->transform(
            function ($sound) {
                if ($sound->type == 'audio') {
                    $media = ['media' => ['audio' => $sound->audio, 'xray_video' => null, 'natural_video' => null, 'picture' => null]];
                } else if ($sound->type == 'video') {
                    $media = ['media' => ['xray_video' => $sound->xray_video, 'natural_video' => $sound->natural_video, 'audio' => null, 'picture' => null]];
                } else if ($sound->type == 'picture') {
                    $media = ['media' => ['picture' => $sound->picture, 'audio' => null, 'xray_video' => null, 'natural_video' => null]];
                }
                return array_merge([
                    'id' => $sound->id,
                    'written_word' => $sound->written_word,
                    'attempts_to_success' => $sound->attempts_to_success,
                    'success_rate' => $sound->success_rate,
                    'letter' => new LetterResource($sound->letter),
                    'sound_progress' => new SoundProgressResource($sound->soundProgress),
                    'type' => $sound->type,
                ], $media);
            }
        )->toArray();
    }

    private function isLocked($level)
    {
        $previous_level_id = Level::where('id', $level->letterProgress->previous_level_id)->first()?->id;
        if (!$previous_level_id) {
            return false;
        }
        if (LevelProgress::where('level_id', $previous_level_id)->where('trainee_id', auth()->user()->id)->first()?->status == 'completed') {
            return false;
        }
        return true;
    }
}
