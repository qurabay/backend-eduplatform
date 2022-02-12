<?php

namespace Modules\Course\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseComment;
use Modules\Course\Http\Requests\CommentRequest;

class CommentController extends Controller
{

    /**
     * @param CommentRequest $request
     * @param Course $course
     * @return JsonResponse
     */
    public function __invoke(CommentRequest $request, Course $course): JsonResponse
    {
        try {
            CourseComment::create([
                'user_id'   => auth()->id(),
                'course_id' => $course->id,
                'text'      => $request->get('text')
            ]);
        }catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Unable create new comment.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Success'
        ], Response::HTTP_OK);
    }
}
