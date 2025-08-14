<?php

namespace App\Http\Controllers;

use App\Contracts\ImageServiceInterface;
use App\Http\Requests\ImageRequest;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    public function __construct(
        private ImageServiceInterface $imageService
    ) {}

    public function store(ImageRequest $request): JsonResponse
    {
        try {
            $image = $this->imageService->uploadImage(
                $request->file('image'),
                $request->get('alt_text')
            );

            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully',
                'data' => $image,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
