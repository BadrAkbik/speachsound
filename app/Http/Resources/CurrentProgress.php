<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrentProgress extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sound' => new SoundResource($this->sound),
            'level_id' => $this->level?->id, 
            'level_name' => $this->level?->name, 
            'level_status' => $this->status,
            'level_progress' => $this->progress,
            'success_attempts' => $this->success_attempts,
            'failure_attempts' => $this->failure_attempts,
        ];
    }
}
