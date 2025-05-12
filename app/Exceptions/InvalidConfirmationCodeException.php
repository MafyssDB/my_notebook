<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Exception;

class InvalidConfirmationCodeException extends Exception
{
    // Наверное у кого-то возник вопрос, а зачем я сделал кастомный Exception для этого случая, ответ прост, я просто щупал кастомные Exception
    public function render($request): \Illuminate\Http\JsonResponse
    {
        return ApiResponse::error('Неверный код подтверждения.');
    }
}
