<?php

namespace App\Repositories\Base;

use App\Contracts\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepository implements BaseRepositoryInterface
{
    public string $model;

    public function all(): Collection
    {
        return $this->model::all();
    }

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
