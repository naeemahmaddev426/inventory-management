<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiResponseTrait;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    protected $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status']);
        $perPage = (int) $request->get('per_page', 10);

        return $this->success(
            CategoryResource::collection($this->service->all($filters, $perPage)),
            'Category List'
        );
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->service->store($request->validated());

        return $this->success(
            new CategoryResource($category),
            'Category Created Successfully',
            201
        );
    }

    public function show($id)
    {
        return $this->success(
            new CategoryResource($this->service->find($id))
        );
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->service->update($id, $request->validated());

        return $this->success(
            new CategoryResource($category),
            'Category Updated Successfully'
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->success(
            null,
            'Category Deleted Successfully'
        );
    }

    public function trashed(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);

        return $this->success(
            CategoryResource::collection($this->service->trashed($perPage)),
            'Trashed Category List'
        );
    }

    public function restore($id)
    {
        $category = $this->service->restore($id);

        return $this->success(
            new CategoryResource($category),
            'Category Restored Successfully'
        );
    }

    public function forceDelete($id)
    {
        $this->service->forceDelete($id);

        return $this->success(
            null,
            'Category Permanently Deleted'
        );
    }
}