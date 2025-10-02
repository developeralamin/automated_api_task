<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    /**
     * Get all Category 
     *
     * @return mixed
     */
    public function getAllCategories(): mixed
    {
        return Category::latest('id')->paginate(30);
    }

    /**
     * Create a Category
     *
     * @param array $data
     *
     * @return mixed
     */

    public function create(array $data): mixed
    {
        return Category::create($data);
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function findOrFail(int $id): mixed
    {
        return Category::findOrFail($id);
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function singleCategory(int $id): mixed
    {
        return $this->findOrFail($id);
    }

    /**
     * Update a Category Information
     *
     * @param int   $id
     *
     * @param array $data
     */
    public function update(int $id, array $data)
    {
        $category = $this->findOrFail($id);

        return $category->update($data);
    }
}
