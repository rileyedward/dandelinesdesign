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

        $storageDisk = $this->getStorageDisk();
        $publicDisk = $this->getPublicDisk();

        Storage::disk($storageDisk)->put($path, file_get_contents($file));

        $url = $this->generateImageUrl($path, $storageDisk, $publicDisk);

        $imageData = [
            'filename' => $filename,
            'original_filename' => $file->getClientOriginalName(),
            'path' => $path,
            'url' => $url,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'alt_text' => $altText,
        ];

        $image = $this->repository->store($imageData);

        return $image->toArray();
    }

    private function getStorageDisk(): string
    {
        if (env('LARAVEL_CLOUD_DISK_CONFIG')) {
            return config('filesystems.default', 'local');
        }

        return config('app.env') === 'production' ? 'cloud' : 'public';
    }

    private function getPublicDisk(): string
    {
        if (env('LARAVEL_CLOUD_DISK_CONFIG')) {
            return config('filesystems.default', 'local');
        }

        return config('app.env') === 'production' ? 'cloud' : 'public';
    }

    private function generateImageUrl(string $path, string $storageDisk, string $publicDisk): string
    {
        // For Laravel Cloud and production, use the configured disk
        return Storage::disk($publicDisk)->url($path);
    }
}
