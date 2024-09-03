<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function words()
    {
        return $this->hasMany(Word::class);
    }

    public function children()
    {
        return $this->belongsToMany(Training::class, 'sub_trainings_trainings', 'parent_id', 'children_id');
    }

    public function parents()
    {
        return $this->belongsToMany(Training::class, 'sub_trainings_trainings', 'children_id', 'parent_id')->withTimestamps();
    }


}
