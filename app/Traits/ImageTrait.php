<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageTrait
{
    public function storeImage ($image, $path, $drive = "public")
    {
        $extension = $image->getClientOriginalExtension();

        $filename = Str::uuid() . '.' . $extension;

        $path = Storage::disk($drive)->putFileAs($path, $image, $filename);
        
        return $path;
    }

    public function deleteImage($path)
    {
        Storage::disk('public')->delete($path);    
    }
}
