<?php

namespace App\Services;

use App\Contracts\ImageRepositoryInterface;
use App\Contracts\ImageServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService extends BaseService implements ImageServiceInterface
{
    public mixed $repository;

    public array $relations = [];

    public function __construct(ImageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function uploadImage(UploadedFile $file, ?string $altText = null): array
    {
        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
        $path = 'images/'.$filename;

        Storage::disk('local')->put($path, $file);

        $imageData = [
            'filename' => $filename,
            'original_filename' => $file->getClientOriginalName(),
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'alt_text' => $altText,
        ];

        $image = $this->repository->store($imageData);

        return $image->toArray();
    }
}
