<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

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

    public function ratings()
    {
        return $this->hasOne(Rating::class);
    }

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
