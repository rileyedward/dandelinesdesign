<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface ImageServiceInterface extends BaseServiceInterface
{
    public function uploadImage(UploadedFile $file, ?string $altText = null): array;
}
