<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
      protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $data = $this->categoryService->getAllCategories();

        return CategoryResource::collection($data);
    }

    public function store(CategoryRequest $request)
    {
        $data     = $request->all();
        $category = $this->categoryService->create($data);

        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, $id)
    {
        $data = $request->all();
        $this->categoryService->update($id, $data);

        return $this->success('Category Updated Successfully');
    }

    public function destroy($id)
    {
        $category = $this->categoryService->findOrFail($id);

        $category->delete();

        return $this->success('Category Deleted Successfully');
    }
}
