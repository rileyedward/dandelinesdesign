<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class BaseController extends Controller
{
    protected string $modelClass;

    protected $serviceInterface;

    protected ?string $requestClass = null;

    protected mixed $service;

    public function __construct()
    {
        $this->service = app($this->serviceInterface);
    }

    public function store(): RedirectResponse
    {
        if (! $this->requestClass) {
            throw new MethodNotAllowedHttpException([], 'Method not allowed');
        }

        $request = app($this->requestClass);
        $validatedData = $request->validated();

        // TODO: Uncomment once authorization policy structure is setup...
        // $this->authorize('store', $this->modelClass);

        $storeData = $this->filterInputData($validatedData);
        $this->service->store($storeData);

        return back();
    }

    public function update(int $id): RedirectResponse
    {
        if (! $this->requestClass) {
            throw new MethodNotAllowedHttpException([], 'Method not allowed');
        }

        $request = app($this->requestClass);
        $validatedData = $request->validated();

        $model = $this->service->getById($id);

        // TODO: Uncomment once authorization policy structure is setup...
        // $this->authorize('update', $model);

        $updateData = $this->filterInputData($validatedData);

        $this->service->update($model, $updateData);

        return back();
    }

    public function destroy(int $id): RedirectResponse
    {
        $model = $this->service->getById($id);

        // TODO: Uncomment once authorization policy structure is setup...
        // $this->authorize('destroy', $model);
        return $this->service->delete($model);
    }

    protected function filterInputData(array $input): array
    {
        return array_filter($input, function ($key) {
            return $key !== 'with';
        }, ARRAY_FILTER_USE_KEY);
    }
}
