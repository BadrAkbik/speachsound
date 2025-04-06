<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected function casts(): array
    {
        return [
            'words' => 'array'
        ];
    }

    public function rating($user_id, $sound_id)
    {
        return $this->hasOne(Rating::class)->where('trainee_id', $user_id)->where('sound_id', $sound_id);
    }
}
