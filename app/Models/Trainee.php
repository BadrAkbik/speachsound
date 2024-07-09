<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trainee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function ratings()
    {
        return $this->belongsToMany(Rating::class, 'ratings');
    }

    public function trainer()
    {
        return $this->morphTo();
    }
    
}
