<?php

namespace App\Services;

use App\Contracts\ImageServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService implements ImageServiceInterface
{
    public function upload(
        ?UploadedFile $file,
        string $path = 'image',
        ?string $oldPath = null,
        ?string $fileName = null
    ) {

        
        if (! $file) {
            return $oldPath;
        }

        $disk = Storage::disk('public');

        $newPath = $fileName
            ? $disk->putFileAs($path, $file, $fileName)
            : $disk->putFile($path, $file);

        if ($oldPath && $oldPath !== $newPath && $disk->exists($oldPath)) {
            $disk->delete($oldPath);
        }

        return $newPath;
    }

    public function delete($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
