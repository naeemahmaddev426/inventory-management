<?php

namespace App\Repositories;

use App\Models\Category;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    protected array $searchable = ['name', 'slug', 'description'];

    public function __construct(Category $category)
    {
        parent::__construct($category);
    }
}