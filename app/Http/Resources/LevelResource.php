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
            'completed_sounds_to_success' => $this->completed_sounds_to_success,
            'progress' => new LevelProgressResource($this->letterProgress),
            'sounds' => $this->sounds ? new SoundCollection($this->sounds) : [],
        ];
    }
}
