<?php

namespace App\Services;

use App\Interfaces\Repositories\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    protected $categoryRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        $categories = $this->categoryRepository->getAllCategories();
        if ($categories->isEmpty()) {
            return ['message' => 'No categories found'];
        }
        return ['data' => $categories];
    }

    public function getCategoryById(int $id)
    {
        $category = $this->categoryRepository->getCategoryById($id);

        if (!$category) {
            return ['message' => 'Category not found'];
        }

        return ['data' => $category];
    }

    public function createCategory(array $data)
    {
        DB::beginTransaction();
        try {
            $category = $this->categoryRepository->createCategory($data);
            DB::commit();
            return ['data' => $category];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    public function updateCategory(int $id, array $data)
    {
        DB::beginTransaction();
        try {
            $category = $this->categoryRepository->getCategoryById($id);

            if (!$category) {
                return ['error' => 'Category not found'];
            }

            $updatedCategory = $this->categoryRepository->updateCategory($id, $data);
            DB::commit();
            return ['data' => $updatedCategory];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteCategory(int $id)
    {
        DB::beginTransaction();
        try {
            $category = $this->categoryRepository->getCategoryById($id);

            if (!$category) {
                return ['error' => 'Category not found'];
            }

            $this->categoryRepository->deleteCategory($id);
            DB::commit();
            return ['message' => 'Category deleted successfully'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

}
