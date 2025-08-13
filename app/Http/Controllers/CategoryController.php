<?php

namespace App\Http\Controllers;

use App\Contracts\CategoryServiceInterface;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Response;

class CategoryController extends BaseController
{
    protected string $modelClass = Category::class;

    protected $serviceInterface = CategoryServiceInterface::class;

    protected ?string $requestClass = CategoryRequest::class;

    public function index(Request $request): Response
    {
        $categories = Category::query()->get();

        return inertia('admin/categories/categories-index', [
            'categories' => $categories,
        ]);
    }

    public function show(Request $request, int $id): Response
    {
        $category = Category::findOrFail($id);

        return inertia('admin/categories/categories-show', [
            'category' => $category,
        ]);
    }
}
