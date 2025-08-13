<?php

namespace App\Http\Controllers;

class BlogController extends Controller
{
    public function index()
    {
        return inertia('blog/blog-index');
    }
}
