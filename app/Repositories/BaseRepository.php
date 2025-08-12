<?php

namespace App\Repositories;

use App\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    public string $model;

    public function findById(int $id): Model
    {
        return $this->model::findOrFail($id);
    }

    public function store(array $data): Model
    {
        return $this->model::create($data);
    }

    public function update(array $data, Model $model): Model
    {
        $model->update($data);

        return $model->fresh();
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }
}
