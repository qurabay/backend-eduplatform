<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Requests\CategoryRequest;
use Modules\Category\Transformers\CategoryResource;

class CategoryController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = Category::with('course')->get();

        return response()->json([
            'data' => CategoryResource::collection($categories)
        ]);
    }

    /**
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        $category->with('courses')->get();
        return response()->json([
            'data' => new CategoryResource($category)
        ]);
    }

    /**
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        try {
            Category::create($request->validated());
        }catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Unable create new category'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Successfully created'
        ], Response::HTTP_OK);
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        try {
            $category->update([
                'section_id' => $request->section_id,
                'name'       => $request->name
            ]);
        }catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Unable update section'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Successfully updated'
        ], Response::HTTP_OK);
    }
}
