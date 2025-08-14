<?php

namespace App\Http\Controllers;

use App\Contracts\ImageServiceInterface;
use App\Http\Requests\ImageRequest;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class ImageController extends Controller
{
    public function __construct(
        private ImageServiceInterface $imageService
    ) {}

    public function index(): Response
    {
        $images = Image::query()
            ->orderBy('updated_at', 'desc')
            ->get();

        return Inertia::render('admin/images/images-index', [
            'images' => $images,
        ]);
    }

    public function list(): JsonResponse
    {
        $images = Image::query()
            ->orderBy('updated_at', 'desc')
            ->get(['id', 'filename', 'original_filename', 'url', 'alt_text']);

        return response()->json([
            'success' => true,
            'data' => $images,
        ]);
    }

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

    public function destroy(string $id): JsonResponse
    {
        try {
            $model = $this->imageService->getById($id);

            $this->imageService->delete($model);

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
