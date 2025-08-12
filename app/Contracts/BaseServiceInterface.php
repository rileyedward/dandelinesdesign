<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface BaseServiceInterface
{
    public function getById(int $id, ?array $relations = null): Model;

    public function store(array $input): Model;

    public function update(array $input, Model $model): Model;

    public function delete(Model $model): bool;
}
