<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class LogoutController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        try {
            auth()->user()->currentAccessToken()->delete();
        }catch (Throwable $throwable) {
            return response()->json([
                'message' => 'Unable to delete token'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Successfully deleted user token'
        ], Response::HTTP_OK);
    }
}
