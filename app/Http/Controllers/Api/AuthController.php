<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $attempt = $this->userRepository->login($data, $request);

            if ($attempt){
                return $this->success('Login successfully', ['user' => UserResource::make(Auth::user())]);
            }

            return $this->unauthorized('Login failed');
        } catch (\Exception $exception) {
            return $this->serverError($exception->getMessage());
        }

    }
}
