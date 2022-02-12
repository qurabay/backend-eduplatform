<?php

namespace Modules\Lesson\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Lesson\Entities\Lesson;
use Modules\Lesson\Http\Requests\LessonRequest;
use Modules\Lesson\Transformers\LessonResource;

class LessonController extends Controller
{

    /**
     * @param Lesson $lesson
     * @return JsonResponse
     */
    public function show(Lesson $lesson): JsonResponse
    {
        return response()->json([
            'data' => LessonResource::collection($lesson)
        ], Response::HTTP_OK);
    }

    /**
     * @param LessonRequest $request
     * @return JsonResponse
     */
    public function store(LessonRequest $request): JsonResponse
    {
        try {
            Lesson::create($request->validated());
        }catch (\Throwable $throwable) {
            return  response()->json([
                'message' => 'Unable create new lesson.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Success'
        ], Response::HTTP_OK);
    }

    /**
     * @param LessonRequest $request
     * @return JsonResponse
     */
    public function update(LessonRequest $request, Lesson $lesson): JsonResponse
    {
        try {
            $lesson->update($request->validated());
        }catch (\Throwable $throwable) {
            return  response()->json([
                'message' => 'Unable create new lesson.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Success'
        ], Response::HTTP_OK);
    }
}
