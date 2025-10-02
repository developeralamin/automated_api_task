<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    private mixed $category_id;
    private mixed $searchProduct;
    private mixed $minPrice;
    private mixed $maxPrice;

    public function __construct(Request $request)
    {
        $this->category_id   = $request->get('category_id');
        $this->searchProduct = $request->get('search');
        $this->minPrice      = $request->get('min_price');
        $this->maxPrice      = $request->get('max_price');
    }

    public function getAllProducts(): mixed
    {
        $query = Product::query();

        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }
        if ($this->searchProduct) {
            $query->where('name', 'LIKE', "%{$this->searchProduct}%");
        }
        if ($this->minPrice !== null) {
            $query->where('price', '>=', $this->minPrice);
        }
        if ($this->maxPrice !== null) {
            $query->where('price', '<=', $this->maxPrice);
        }
        // Paginate results
        return $query->latest('id')->paginate(100);
    }


    public function create(array $data): mixed
    {
        return Product::create($data);
    }


    public function findOrFail(int $id): mixed
    {
        return Product::findOrFail($id);
    }

    public function singleProduct(int $id): mixed
    {
        return $this->findOrFail($id);
    }
    
    public function update(int $id, array $data)
    {
        $product = $this->findOrFail($id);

        return $product->update($data);
    }
}
