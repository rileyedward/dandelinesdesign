<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogPostRequest;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function index(): Response
    {
        $posts = BlogPost::query()->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('blog/blog-index', [
            'blogPosts' => $posts,
        ]);
    }

    public function admin(): Response
    {
        // TODO: Add authorization policy...

        $posts = BlogPost::query()->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('/admin/admin-blog', [
            'blogPosts' => $posts,
        ]);
    }

    public function store(BlogPostRequest $request): RedirectResponse
    {
        // TODO: Add authorization policy....

        BlogPost::query()->create($request->validated());

        return redirect()->back();
    }

    public function update(BlogPostRequest $request, BlogPost $blogPost): RedirectResponse
    {
        // TODO: Add authorization policy...

        $blogPost->update($request->validated());

        return redirect()->back();
    }

    public function show(BlogPost $blogPost): Response
    {
        return Inertia::render('blog/blog-show', [
            'blogPost' => $blogPost,
        ]);
    }
}
