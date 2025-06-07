<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TestimonialController extends Controller
{
    public function admin(): Response
    {
        $testimonials = Testimonial::query()
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('admin/admin-testimonials', [
            'testimonials' => $testimonials,
        ]);
    }

    public function store(TestimonialRequest $request): RedirectResponse
    {
        Testimonial::query()->create($request->validated());

        return redirect()->back();
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update($request->validated());

        return redirect()->back();
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect()->back();
    }
}
