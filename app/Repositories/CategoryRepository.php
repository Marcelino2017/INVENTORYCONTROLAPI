<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{

    protected $model;
    /**
     * Create a new class instance.
     */
    public function __construct(
        Category $model
    ) {
        $this->model = $model;
    }

    public function getAllCategories()
    {
        return $this->model->all();
    }

    public function getCategoryById(int $id)
    {
        return $this->model->find($id);
    }

    public function createCategory(array $data)
    {
        return $this->model->create($data);
    }

    public function updateCategory(int $id, array $data)
    {
        $category = $this->getCategoryById($id);
        if (!$category) {
            return null;
        }
        $category->update($data);
        return $category;
    }

    public function deleteCategory(int $id)
    {
        $category = $this->getCategoryById($id);
        if (!$category) {
            return false;
        }
        $category->delete();
        return $category;
    }
}
