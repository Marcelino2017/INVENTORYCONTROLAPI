<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{

    protected $categoryService;

    public function __construct(
        \App\Services\CategoryService $categoryService
    ) {

        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        if (isset($categories['message'])) {
            return response()->json($categories, 404);
        }
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();
        $category = $this->categoryService->createCategory($data);
        return response()->json($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $category = $this->categoryService->getCategoryById($id);
        if (isset($category['error'])) {
            return response()->json($category, 404);
        }
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, int $category)
    {
        $data = $request->all();
        $category = $this->categoryService->updateCategory($category, $data);

        if (isset($category['error'])) {
            return response()->json($category['error'], 404);
        }

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $deleted = $this->categoryService->deleteCategory($id);

        if (isset($deleted['message'])) {
            return response()->json($deleted, 404);
        }

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
