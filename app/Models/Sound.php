<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sound extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function words()
    {
        return $this->hasMany(Word::class);
    }
}
