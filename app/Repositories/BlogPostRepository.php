<?php

namespace App\Repositories;

use App\Contracts\BlogPostRepositoryInterface;
use App\Models\BlogPost;

class BlogPostRepository extends BaseRepository implements BlogPostRepositoryInterface
{
    public string $model = BlogPost::class;
}
