<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    public function findById(int $id): Model;

    public function store(array $data): Model;

    public function update(array $data, Model $model): Model;

    public function delete(Model $model): bool;
}
