<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface ImageServiceInterface
{
    public function upload(
        ?UploadedFile $file,
        string $path = 'image',
        ?string $oldPath = null,
        ?string $fileName = null
    );

    public function delete($path);
}
