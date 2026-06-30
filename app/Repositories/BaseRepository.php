<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    protected array $searchable = [];

    public function all(array $filters = [], int $perPage = 10)
    {
        $query = $this->model->query()->latest();

        if (!empty($filters['search']) && !empty($this->searchable)) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                foreach ($this->searchable as $field) {
                    $q->orWhere($field, 'like', "%{$search}%");
                }
            });
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        return $query->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $model = $this->find($id);

        $model->update($data);

        return $model;
    }

    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }

    public function trashed(int $perPage = 10)
    {
        return $this->model->onlyTrashed()->latest()->paginate($perPage);
    }

    public function restore(int $id)
    {
        $model = $this->model->onlyTrashed()->findOrFail($id);

        $model->restore();

        return $model;
    }

    public function forceDelete(int $id)
    {
        return $this->model->onlyTrashed()->findOrFail($id)->forceDelete();
    }
}