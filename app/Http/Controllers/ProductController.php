<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(
        ProductService $productService
    ) {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productService->getAllProducts();
        if (isset($products['message'])) {
            return response()->json($products, 404);
        }
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->all();
        $product = $this->productService->createProduct($data);

        if(isset($product['error'])) {
            return response()->json($product['error'], 500);
        }

        return response()->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Int $id)
    {
        $product = $this->productService->getProductById($id);

        if (isset($product['message'])) {
            return response()->json($product, 404);
        }

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Int $id)
    {
        $data = $request->all();
        $product = $this->productService->updateProduct($id, $data);

        if (isset($product['error'])) {
            return response()->json(['error' => $product['error']], 404);
        }

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Int $id)
    {
        $deleted = $this->productService->deleteProduct($id);

        if (isset($deleted['message'])) {
            return response()->json($deleted, 404);
        }

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
