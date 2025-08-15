<?php

namespace App\Http\Controllers;

use App\Contracts\BlogPostServiceInterface;
use App\Http\Requests\BlogPostRequest;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class BlogPostController extends BaseController
{
    protected string $modelClass = BlogPost::class;

    protected $serviceInterface = BlogPostServiceInterface::class;

    protected ?string $requestClass = BlogPostRequest::class;

    public function index(Request $request): Response
    {
        $blogPosts = BlogPost::query()
            ->orderBy('updated_at', 'desc')
            ->get();

        return inertia('admin/blog-posts/blog-posts-index', [
            'blogPosts' => $blogPosts,
        ]);
    }

    public function create(Request $request): Response
    {
        return inertia('admin/blog-posts/blog-posts-create');
    }

    public function store(): RedirectResponse
    {
        if (! $this->requestClass) {
            throw new MethodNotAllowedHttpException([], 'Method not allowed');
        }

        $request = app($this->requestClass);
        $validatedData = $request->validated();

        // TODO: Uncomment once authorization policy structure is setup...
        // $this->authorize('store', $this->modelClass);

        $storeData = $this->filterInputData($validatedData);
        $blogPost = $this->service->store($storeData);

        return to_route('admin.blog.show', $blogPost->id);
    }

    public function show(Request $request, int $id): Response
    {
        $blogPost = BlogPost::findOrFail($id);

        return inertia('admin/blog-posts/blog-posts-show', [
            'blogPost' => $blogPost,
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        $model = $this->service->getById($id);

        // TODO: Uncomment once authorization policy structure is setup...
        // $this->authorize('destroy', $model);

        $this->service->delete($model);

        return to_route('admin.blog.index');
    }
}
