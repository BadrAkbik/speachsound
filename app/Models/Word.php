<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = ['words' => 'array'];


    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function sound()
    {
        return $this->belongsTo(Sound::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }
}
