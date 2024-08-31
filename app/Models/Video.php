<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($trainig) {
            if ($trainig->videos()) {
                //delete
            }
        });

        static::updating(function ($file) {
            // Delete the file
            if ($file->isdirty()) {
                $originalFile = $file->getOriginal('path');
                if ($originalFile) {
                    //delete video
                }
            }
        });
    }

    public function sound()
    {
        return $this->belongsTo(Sound::class);
    }
}
