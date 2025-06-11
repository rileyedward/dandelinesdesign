<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogPostRequest;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $posts = BlogPost::query()
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('admin/admin-blog', [
            'blogPosts' => $posts,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/admin-blog-create');
    }

    public function edit(BlogPost $blogPost): Response
    {
        return Inertia::render('admin/admin-blog-edit', [
            'blogPost' => $blogPost,
        ]);
    }

    public function store(BlogPostRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['title']);

        if (! isset($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($data['content']), 150);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'_'.$image->getClientOriginalName();

            $path = $image->storeAs('images/blog', $filename, 'public');

            $data['image_url'] = '/storage/'.$path;
        }

        BlogPost::query()->create($data);

        return redirect()->route('admin.blog.index');
    }

    public function update(BlogPostRequest $request, BlogPost $blogPost): RedirectResponse
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['title']);

        if (! isset($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($data['content']), 150);
        }

        if ($request->hasFile('image')) {
            if ($blogPost->image_url) {
                $oldPath = str_replace('/storage/', '', $blogPost->image_url);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $image = $request->file('image');
            $filename = time().'_'.$image->getClientOriginalName();

            $path = $image->storeAs('images/blog', $filename, 'public');

            $data['image_url'] = '/storage/'.$path;
        }

        $blogPost->update($data);

        return redirect()->route('admin.blog.index');
    }

    public function show(BlogPost $blogPost): Response
    {
        return Inertia::render('blog/blog-show', [
            'blogPost' => $blogPost,
        ]);
    }

    public function destroy(BlogPost $blogPost): RedirectResponse
    {
        $blogPost->delete();

        return redirect()->route('admin.blog.index');
    }
}
