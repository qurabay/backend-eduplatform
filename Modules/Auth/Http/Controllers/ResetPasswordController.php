<?php

namespace Modules\Auth\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{

    /**
     * @param User $user
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function reset(User $user, ResetPasswordRequest $request): JsonResponse
    {
        if ($request->get('password') == $request->get('confirm_password')) {
            $user->update([
                'password' => bcrypt($request->get('password'))
            ]);

            return response()->json([
                'message' => 'Succesfully changed'
            ], Response::HTTP_OK);
        }
        return response()->json([
            'message' => 'Please try again'
        ], Response::HTTP_BAD_REQUEST);

    }
}
