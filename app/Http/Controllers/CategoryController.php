<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\Categories\CategoryService;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    // This trait provides standardized methods for API responses.
    use ApiResponseTrait;

    // Dependency injection for CategoryService to handle business logic.
    protected CategoryService $categoryService;

    /**
     * Constructor to inject the CategoryService into the controller.
     * 
     * @param CategoryService $categoryService The service class responsible for handling business logic.
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of categoies with pagination.
     * 
     * @return JsonResponse Paginated list of categoies in JSON format.
     */
    public function index(): JsonResponse
    {
        $categories = Category::paginate(5);
        return $this->responseApi(
            CategoryResource::collection($categories),
            'Categories with their categories retrieved successfully',
            200
        );
    }

    /**
     * Store a newly created category in the database.
     * 
     * @param StoreCategoryRequest $request Validated request object containing category details.
     * @return JsonResponse Response with created category data and success message.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->store($request);
        return $this->responseApi(
            new CategoryResource($category),
            'Category Store Successfully',
            201
        );
    }

    /**
     * Display a specific category along with its associated categories.
     *
     * @param Category $category The category model injected by route-model binding.
     * @return JsonResponse Category with its categories in JSON format.
     */
    public function show(Category $category): JsonResponse
    {
        return $this->responseApi(
            new CategoryResource($category),
            'Category with its categories retrieved successfully',
            200
        );
    }

    /**
     * Update an existing category in the database.
     * 
     * @param UpdateCategoryRequest $request Validated request object with updated category details.
     * @param Category $category The category instance to update.
     * @return JsonResponse Response with updated category data and success message.
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $data = $this->categoryService->update($category, $request->validated());
        return $this->responseApi(
            new CategoryResource($data),
            'Category Update Successfully',
            200
        );
    }

    /**
     * Remove a category from the database.
     * 
     * @param Category $category The category instance to delete.
     * @return JsonResponse Response with success message after deletion.
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->categoryService->delete($category);
        return $this->responseApi(
            true,
            'Category Delete Successfully',
            200
        );
    }
}
