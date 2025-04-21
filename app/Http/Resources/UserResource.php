<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_picture' => $this->profile_picture,
            'gender' => $this->gender,
            'age_group' => $this->ageGroup?->name,
            'year_of_birth' => $this->year_of_birth,
            'profile_completion_status' => $this->profile_completion_status,
            'phone_code' => $this->phone_code,
            'phone_number' => $this->phone_number,
        ];
    }
}
