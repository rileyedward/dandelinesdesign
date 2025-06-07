<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;

class TestimonialController extends Controller
{
    public function store(TestimonialRequest $request): RedirectResponse
    {
        Testimonial::query()->create($request->validated());

        return redirect()->back();
    }
}
