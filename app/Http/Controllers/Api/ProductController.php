<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $data = $this->productService->getAllProducts();

        return ProductResource::collection($data);
    }

    public function store(ProductRequest $request)
    {
        $data     = $request->all();
        $product = $this->productService->create($data);

        return new ProductResource($product);
    }


    public function show($id)
    {
        $product = $this->productService->findOrFail($id);

       return new ProductResource($product);
    }
    

    public function update(UpdateProductRequest $request, $id)
    {
        $data = $request->all();
        $data = $this->productService->update($id, $data);

        return $this->success('Product Updated Successfully');
    }

    public function destroy($id)
    {
        $product = $this->productService->findOrFail($id);

        $product->delete();

        return $this->success('Product Deleted Successfully');
    }
}
