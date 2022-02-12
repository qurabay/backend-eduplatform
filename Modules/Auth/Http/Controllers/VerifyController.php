<?php

namespace Modules\Auth\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Modules\Auth\Http\Requests\SendCodeRequest;
use Modules\Auth\Transformers\UserResource;

class VerifyController extends Controller
{

    /**
     * @param SendCodeRequest $request
     * @return JsonResponse
     */
    public function sendCode(SendCodeRequest $request): JsonResponse
    {
        try {
            $user = User::where('phone', $request->get('phone'))->first();
            if ($user) {
                Cache::put($request->get('phone'), 1111, now()->addMinutes(5));
            }
        } catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Error while sending sms code',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Sms Send Success',
            'data' => new UserResource($user)
        ], Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyPhone(User $user, Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required'
        ]);

        if (Cache::get($user->phone) == $request->code) {
            if ($user) {
                $user->update(['phone_verified' => Str::uuid()->toString()]);

                return response()->json([
                    'token' => $user->createToken('user-token')->plainTextToken,
                ],Response::HTTP_OK);
            }
        }
        return response()->json([
            'token' => 'Invalid sms code.',
        ],Response::HTTP_UNAUTHORIZED);
    }
}
