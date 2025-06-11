<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function index(): Response
    {
        $testimonials = Testimonial::query()->get();

        return Inertia::render('about/about-index', [
            'testimonials' => $testimonials,
        ]);
    }
}
