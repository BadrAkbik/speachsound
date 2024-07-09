<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'words' => 'array',
            'images' => 'array',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($trainig) {
            if ($trainig->videos()) {
                //delete
            }
        });
    }

    public function videos()
    {
        return $this->morphMany(Video::class, 'related');
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
