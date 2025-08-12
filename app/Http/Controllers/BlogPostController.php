<?php

namespace App\Http\Controllers;

use App\Contracts\BlogPostServiceInterface;
use App\Http\Requests\BlogPostRequest;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Inertia\Response;

class BlogPostController extends BaseController
{
    protected string $modelClass = BlogPost::class;

    protected $serviceInterface = BlogPostServiceInterface::class;

    protected ?string $requestClass = BlogPostRequest::class;

    public function index(Request $request): Response
    {
        return inertia('admin/blog-posts/blog-posts-index');
    }

    public function show(Request $request, int $id): Response
    {
        return inertia('admin/blog-posts/blog-posts-show');
    }
}
