<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Center extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function specialists()
    {
        return $this->hasMany(Specialist::class, 'specialist_id');
    }
}
