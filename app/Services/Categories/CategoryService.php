<?php

namespace App\Services\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Exception;

class CategoryService
{
    /**
     * Store a newly created category in the database.
     * 
     * @param object $data The validated request object containing the category data (e.g., title, author, etc.).
     * @return \App\Models\Category The created Category instance.
     * @throws \Exception If the creation of the category fails, an exception is thrown.
     */
    public function store($data): Category
    {
        try {
            return Category::create([
                'name'        => $data->name,
                'description' => $data->description
            ]);
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception('Failed to created category: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing category in the database.
     * 
     * @param \App\Models\Category $category The category instance to be updated.
     * @param array $data The array containing updated category data.
     * @return \App\Models\Category The updated category instance.
     * @throws \Exception If the update operation fails, an exception is thrown.
     */
    public function update(Category $category, $data): Category
    {
        try {
            $category->update([
                'name'        => $data['name'] ?? $category->name,
                'description' => $data['description'] ?? $category->description
            ]);
            return $category->refresh();;
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception('Failed to updated category: ' . $e->getMessage());
        }
    }

    /**
     * Delete a category from the database.
     * 
     * @param \App\Models\Category $category The category instance to be deleted.
     * @return void
     * @throws \Exception If the deletion operation fails, an exception is thrown.
     */
    public function delete(Category $category): void
    {
        try {
            $category->delete();
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception('Failed to deleted category: ' . $e->getMessage());
        }
    }
}