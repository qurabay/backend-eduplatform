<?php

namespace Modules\Auth\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Transformers\UserResource;

class RegisterController extends Controller
{

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = User::create([
                'name'      => $request->get('name'),
                'phone'     => $request->get('phone'),
                'password'  => bcrypt($request->get('password'))
            ]);
        }catch (\Throwable $th) {
            return response()->json([
                'message' => 'Unable to new User'. $th
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => new UserResource($user)
        ], Response::HTTP_OK);
    }
}
