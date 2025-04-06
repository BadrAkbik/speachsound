<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sound_id' => $this->sound_id,
            'level' => ['id' => $this->level?->id, 'name' => $this->level?->name, 'words' => $this->level?->words],
            'degree' => $this->degree,
            'success_attempts' => $this->success_attempts,
            'failure_attempts' => $this->failure_attempts,
            'records' => $this->records
        ];
    }
}
