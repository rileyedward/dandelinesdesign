<?php

namespace App\Contracts\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface BaseServiceInterface
{
    public function getAll(): Collection;

    public function show(Request $request, Model $model): Model;

    public function getById(int $id, ?array $relations = null): Model;

    public function store(array $input): Model;

    public function update(array $input, Model $model): Model;

    public function delete(Model $model): bool;
}
