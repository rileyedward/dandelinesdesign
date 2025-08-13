<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;

class AboutController extends Controller
{
    public function __invoke()
    {
        $testimonials = Testimonial::query()->where('is_active', true)->get();

        return inertia('about/about-index', [
            'testimonials' => $testimonials,
        ]);
    }
}
