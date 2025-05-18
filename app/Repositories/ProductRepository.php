<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{

    protected $model;
    /**
     * Create a new class instance.
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getAllProducts()
    {
        return $this->model->all();
    }

    public function getProductById(int $id)
    {
        $product = $this->model->find($id);
        if (!$product) {
            return null;
        }
        return $product;
    }

    public function createProduct(array $data)
    {
        return $this->model->create($data);
    }

    public function updateProduct(int $id, array $data)
    {
        $product = $this->getProductById($id);
        if (!$product) {
            return null;
        }
        $product->update($data);
        return $product;
    }

    public function deleteProduct(int $id)
    {
        $product = $this->getProductById($id);
        if (!$product) {
            return null;
        }
        $product->delete();
        return $product;
    }

}
