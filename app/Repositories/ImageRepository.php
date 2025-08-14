<?php

namespace App\Repositories;

use App\Contracts\ImageRepositoryInterface;
use App\Models\Image;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{
    public string $model = Image::class;
}
