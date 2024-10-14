<?php

namespace App\Http\Controllers\V1;

use App\Actions\Authentication\Login;
use App\Http\Controllers\Controller;
use App\Http\Requests\Token\LoginRequest;
use App\Http\Requests\Token\RegisterRequest;
use App\Http\Resources\PersonalAccessTokenResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends Controller
{
    public function __construct(
        private readonly User $user,
    ) {
    }

    public function login(LoginRequest $request): JsonResource|JsonResponse
    {
        $input = $request->validated();

        $credentials = [
            'email' => $input['email'],
            'password' => $input['password'],
        ];

        if (auth()->validate($credentials)) {
            $user = $this->user->where('email', $credentials['email'])->first();

            $personalAccessToken = Login::run($user, $request->header('User-Agent') ?? '');

            return new PersonalAccessTokenResource($personalAccessToken);
        }

        return response()->json(status: Response::HTTP_NOT_FOUND);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

    public function register(RegisterRequest $request): JsonResource
    {
        $user = $this->user->create($request->validated());

        $personalAccessToken = Login::run($user, $request->header('User-Agent') ?? '');

        return new PersonalAccessTokenResource($personalAccessToken);
    }
}
