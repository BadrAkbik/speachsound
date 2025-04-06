<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'words' => $this->words,
            'progress' => (($this->rating(auth()->user()->id, $request->sound_id)->first()->success_attempts / $this->success_attempts) * 100) . '%',
            'banner_image' => $this->banner_image,
            'audio' => $this->audio,
            'xray_video' => $this->xray_video,
            'natural_video' => $this->natural_video,
            'success_attempts' => $this->success_attempts
        ];
    }
}
