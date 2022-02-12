<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Section;
use Modules\Category\Http\Requests\SectionRequest;
use Modules\Category\Transformers\SectionResource;

class SectionController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => SectionResource::collection(Section::with('categories')->get())
        ], Response::HTTP_OK);
    }

    /**
     * @param Section $section
     * @return JsonResponse
     */
    public function show(Section $section): JsonResponse
    {
        return response()->json([
            'data' => new SectionResource($section)
        ], Response::HTTP_OK);
    }

    /**
     * @param SectionRequest $request
     * @return JsonResponse
     */
    public function store(SectionRequest $request): JsonResponse
    {
        try {
            $section = Section::create($request->validated());
        }catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Unable create new section'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $section
        ], Response::HTTP_OK);
    }

    /**
     * @param SectionRequest $request
     * @param Section $section
     * @return JsonResponse
     */
    public function update(SectionRequest $request, Section $section): JsonResponse
    {
        try {
            $section->update([
                'name' => $request->name
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
