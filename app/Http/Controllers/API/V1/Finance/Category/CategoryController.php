<?php

namespace App\Http\Controllers\API\V1\Finance\Category;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Finance\CategoryRequest;
use App\Http\Resources\API\V1\Finance\CategoryResource;
use App\Repositories\Finance\Category\CategoryRepository;
use Illuminate\Http\JsonResponse;


abstract class CategoryController extends Controller
{
    public function __construct(private readonly CategoryRepository $categoryRepository){}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $categories = $this->categoryRepository->getAll();
        return ApiResponse::success(CategoryResource::collection($categories));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $category = $this->categoryRepository->create($request->toDto());
        return ApiResponse::success(CategoryResource::make($category));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $category = $this->categoryRepository->getOne($id);
        return ApiResponse::success(CategoryResource::make($category));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id): JsonResponse
    {
        $category = $this->categoryRepository->update($request->toDto(), $id);
        return ApiResponse::success(CategoryResource::make($category));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->categoryRepository->delete($id);
        return ApiResponse::success(message: 'Категория удалена!');
    }
}
