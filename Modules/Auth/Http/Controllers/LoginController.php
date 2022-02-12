<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Transformers\UserResource;

class LoginController extends Controller
{

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt([
            'phone' => $request->phone,
            'password' => $request->password])) {

            return response()->json([
                'message' => 'Phone or Password invalid'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'user' => new UserResource(auth()->user()),
            'token' => auth()->user()->createToken('user-token')->plainTextToken
        ], Response::HTTP_OK);
    }
}
