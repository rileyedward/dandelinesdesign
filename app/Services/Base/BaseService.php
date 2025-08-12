<?php

namespace App\Services\Base;

use App\Contracts\Base\BaseServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

abstract class BaseService implements BaseServiceInterface
{
    public mixed $repository;

    public array $relations = [];

    public array $commonRelations = [];

    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    public function show(Request $request, Model $model): Model
    {
        return $model;
    }

    public function getById(int $id, ?array $relations = null): Model
    {
        $model = $this->repository->findById($id);
        $relationsToLoad = $this->resolveRelations($relations);

        return $this->loadRelationships($model, $relationsToLoad);
    }

    public function store(array $input, ?array $relations = null): Model
    {
        $model = $this->repository->store($input);
        $relationsToLoad = $this->resolveRelations($relations);

        return $this->loadRelationships($model, $relationsToLoad);
    }

    public function update(array $input, Model $model, ?array $relations = null): Model
    {
        $updatedModel = $this->repository->update($input, $model);
        $relationsToLoad = $this->resolveRelations($relations);

        return $this->loadRelationships($updatedModel, $relationsToLoad);
    }

    public function delete(Model $model): bool
    {
        return $this->repository->delete($model);
    }

    public function getAllRelations(): array
    {
        return array_merge($this->commonRelations, $this->relations);
    }

    protected function loadRelationships(Model $model, array $relations): Model
    {
        if (! empty($relations)) {
            $model->load($relations);
        }

        return $model;
    }

    protected function resolveRelations(?array $requestedRelations = null): array
    {
        if ($requestedRelations === null) {
            return $this->getAllRelations();
        }

        $allowedRelations = $this->getAllRelations();
        $filteredRelations = array_intersect($requestedRelations, $allowedRelations);

        return array_values($filteredRelations);
    }
}
