<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Exceptions\InvalidConfirmationCodeException;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\Login\CodeRequest;
use App\Http\Requests\API\V1\Auth\Login\LoginRequest;
use App\Http\Requests\API\V1\Auth\RegisterRequest;
use App\Notifications\LoginCode;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Random\RandomException;

class AuthController extends Controller
{

    public function __construct(
        private readonly UserService $userService
    )
    {
    }

    /**
     * @throws RandomException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $this->userService->register($request->toDto());
        return ApiResponse::success(
            message: 'Регистрация прошла успешно!',
            code: 201
        );
    }

    /**
     * @throws RandomException
     */
    public function sendLoginCode(CodeRequest $request): JsonResponse
    {
        $user = $this->userService->sendLoginCode($request->email);
        return ApiResponse::success(
            ['email' => $user->email],
            'Код подтверждения отправлен на почту: ' . $user->email
        );
    }

    /**
     * @throws InvalidConfirmationCodeException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->userService->login($request->toDto());
        return ApiResponse::success([
            'token' => $user->createToken('auth-token')->plainTextToken,
            'user' => $user
        ]);
    }

    public function logout(): void
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
    }

    public function logoutAll(): void
    {
        $user = Auth::user();
        $user->tokens()->delete();
    }
}
