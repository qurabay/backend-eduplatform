<?php

namespace Modules\Course\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;
use Modules\Course\Http\Requests\CourseRequest;
use Modules\Course\Transformers\CourseResource;

class CourseController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function show(Course $course): JsonResponse
    {
        return response()->json([
            'data' => new CourseResource($course)
        ], Response::HTTP_OK);
    }

    /**
     * @param CourseRequest $request
     * @return JsonResponse
     */
    public function store(CourseRequest $request): JsonResponse
    {
        try {
            $course = Course::create($request->validated());
        }catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Unable create new course'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Successfully created',
            'data'    => new CourseResource($course)
        ], Response::HTTP_OK);
    }

    /**
     * @param CourseRequest $request
     * @param Course $course
     * @return JsonResponse
     */
    public function update(CourseRequest $request, Course $course): JsonResponse
    {
        try {
            $course->update([
                'category_id' => $request->get('category_id'),
                'name'        => $request->get('name'),
                'description' => $request->get('description'),
            ]);
        }catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Unable create new course'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Successfully created',
        ], Response::HTTP_OK);
    }
}
