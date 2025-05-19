<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(
        CategoryService $categoryService
    ) {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Category::class);
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
        $this->authorize('create', Category::class);
        $data = $request->all();
        $category = $this->categoryService->createCategory($data);

        if(isset($category['error'])) {
            return response()->json($category['error'], 500);
        }

        return response()->json($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $this->authorize('viewAny', Category::class);
        $category = $this->categoryService->getCategoryById($id);
        if (isset($category['error'])) {
            return response()->json($category, 404);
        }

        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, int $id)
    {
        $this->authorize('update', Category::class);
        $data = $request->all();
        $category = $this->categoryService->updateCategory($id, $data);

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
        $this->authorize('delete', Category::class);
        $deleted = $this->categoryService->deleteCategory($id);

        if (isset($deleted['message'])) {
            return response()->json($deleted, 404);
        }

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
