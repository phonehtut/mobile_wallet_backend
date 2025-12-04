<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ){}

    /**
     * @unauthenticated
     */
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

    /**
     * @unauthenticated
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $user = $this->userRepository->register($data, $request);

            return $this->success('Registered successfully', [
                'user' => UserResource::make($user)
            ]);
        } catch (\Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }


    public function find(int $phone): JsonResponse
    {
        try {
            $user = $this->userRepository->searchWithPhone($phone);

            if (!$user){
                return $this->notFound('User not found');
            }

            return $this->success('User found', ['user' => UserResource::make($user)]);
        } catch (\Exception $exception) {
            return $this->serverError($exception->getMessage());
        }
    }
}
