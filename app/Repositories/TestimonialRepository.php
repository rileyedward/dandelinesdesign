<?php

namespace App\Repositories;

use App\Contracts\TestimonialRepositoryInterface;
use App\Models\Testimonial;

class TestimonialRepository extends BaseRepository implements TestimonialRepositoryInterface
{
    public string $model = Testimonial::class;
}
