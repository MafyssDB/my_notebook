<?php

namespace App\Http\Requests\API\V1\Auth\Email;

use App\Rules\EmailVerified;
use Illuminate\Foundation\Http\FormRequest;

class ResendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email', new EmailVerified]
        ];
    }

    public function messages(): array
    {
        return [
            // email
            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Поле "Email" должно быть действительным электронным адресом.',
            'email.exists' => 'Пользователь с таким Email не найден!',
        ];
    }
}
