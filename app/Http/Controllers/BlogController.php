<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Inertia\Response;

class BlogController extends Controller
{
    public function index(): Response
    {
        $blogPosts = BlogPost::query()
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return inertia('blog/blog-index', [
            'blogPosts' => $blogPosts,
        ]);
    }

    public function show(Request $request, string $slug): Response
    {
        $blogPost = BlogPost::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return inertia('blog/blog-show', [
            'blogPost' => $blogPost,
        ]);
    }
}
