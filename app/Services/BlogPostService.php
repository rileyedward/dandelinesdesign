<?php

namespace App\Services;

use App\Contracts\BlogPostRepositoryInterface;
use App\Contracts\BlogPostServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPostService extends BaseService implements BlogPostServiceInterface
{
    public mixed $repository;

    public array $relations = [];

    public function __construct(BlogPostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $input): Model
    {
        $input['slug'] = Str::slug($input['title']);

        return $this->repository->store($input);
    }
}
