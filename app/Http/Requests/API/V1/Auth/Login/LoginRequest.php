<?php

namespace App\Http\Requests\API\V1\Auth\Login;

use App\DTO\EmailCodeRequestDTO;
use App\Rules\EmailNotVerified;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'code' => 'required|string|size:6',
            'email' => ['required', 'email', 'exists:users,email', new EmailNotVerified()]
        ];
    }

    public function messages(): array
    {
        return [
            // code
            'code.required' => 'Поле "Код" обязательно для заполнения.',
            'code.string' => 'Поле "Код" должно быть строкой.',
            'code.size' => 'Поле "Код" должно состоять из 6 символов.',

            // email
            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Поле "Email" должно быть действительным электронным адресом.',
            'email.exists' => 'Пользователь с таким Email не найден!',
        ];
    }

    public function toDto(): EmailCodeRequestDTO
    {
        return EmailCodeRequestDTO::fromData($this->validated());
    }
}
