<?php

namespace App\Http\Controllers;

use App\Contracts\TestimonialServiceInterface;
use App\Http\Requests\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Inertia\Response;

class TestimonialController extends BaseController
{
    protected string $modelClass = Testimonial::class;

    protected $serviceInterface = TestimonialServiceInterface::class;

    protected ?string $requestClass = TestimonialRequest::class;

    public function index(Request $request): Response
    {
        $testimonials = Testimonial::query()
            ->orderBy('updated_at', 'desc')
            ->get();

        return inertia('admin/testimonials/testimonials-index', [
            'testimonials' => $testimonials,
        ]);
    }
}
