<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tests()
    {
        return $this->hasMany(Test::class, 'level_id');
    }

    public function trainings()
    {
        return $this->hasMany(Training::class, 'level_id');
    }

    public function ageGroup()
    {
        return $this->belongsTo(AgeGroup::class, 'age_group_id');
    }
}
