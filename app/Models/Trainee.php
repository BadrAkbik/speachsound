<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trainee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function test()
    {
        return $this->hasManyThrough(Test::class, Rating::Class);
    }

    public function trainer()
    {
        return $this->morphTo();
    }

}
