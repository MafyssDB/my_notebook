<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Exceptions\InvalidConfirmationCodeException;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\Email\ResendRequest;
use App\Http\Requests\API\V1\Auth\Email\VerifyRequest;
use App\Notifications\EmailVerificationCode;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Random\RandomException;

class EmailVerifyController extends Controller
{

    public function __construct(
        private readonly UserService $userService
    )
    {
    }

    /**
     * @throws RandomException
     */
    public function resend(ResendRequest $request): JsonResponse
    {
        $this->userService->resendConfirmCode($request->email, EmailVerificationCode::class);
        return ApiResponse::success(
            message: 'Код подтверждения повторно отправлен на почту: ' . $request->email,
        );
    }

    /**
     * @throws InvalidConfirmationCodeException
     */
    public function verify(VerifyRequest $request): JsonResponse
    {
        $this->userService->verifyEmail($request->toDto());
        return ApiResponse::success(
            message: 'Email подтверждён!'
        );
    }
}
