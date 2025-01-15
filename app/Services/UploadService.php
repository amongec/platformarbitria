<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class UploadService
{

    public static function upload(UploadedFile $file, string $folder, $disk = 'public'):string
    {
       $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
       $extension = $file->getClientOriginalExtension();
       $filename = $filename . '-' . time() . '.' . $extension;
       return $file->storeAs($folder, $filename, $disk);
    }

    public static function delete(string $path, $disk = 'public'): bool{
        if (! Storage::disk($disk)->exists($path)){
            return false;
        }
        return Storage::disk($disk)->delete($path);
    }

    public static function url(string $path, string $disk = 'public'): string{
         return Storage::disk($disk)->url($path);
    }
}