<?php

namespace App\Services;

use App\Interfaces\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductService
{

    protected $productRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }


    public function getAllProducts()
    {
        $products = $this->productRepository->getAllProducts();
        if ($products->isEmpty()) {
            return ['message' => 'No products found'];
        }
        return ['data' => $products];
    }


    public function getProductById(int $id)
    {
        $product = $this->productRepository->getProductById($id);
        if (!$product) {
            return ['message' => 'Product not found'];
        }
        return ['data' => $product];
    }

    public function createProduct(array $data)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->createProduct($data);
            DB::commit();
            return ['data' => $product];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    public function updateProduct(int $id, array $data)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->getProductById($id);

            if (!$product) {
                return ['message' => 'Product not found'];
            }

            $updatedProduct = $this->productRepository->updateProduct($id, $data);
            DB::commit();
            return ['data' => $updatedProduct];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteProduct(int $id)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->getProductById($id);

            if (!$product) {
                return ['message' => 'Product not found'];
            }

            $deletedProduct = $this->productRepository->deleteProduct($id);
            DB::commit();
            return ['data' => $deletedProduct];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }


}
