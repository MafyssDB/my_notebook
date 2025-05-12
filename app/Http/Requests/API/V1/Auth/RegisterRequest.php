<?php

namespace App\Http\Requests\API\V1\Auth;

use App\DTO\UserDTO;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
        ];
    }
    public function messages(): array
    {
        return [
            // name
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.string' => 'Поле "Имя" должно быть строкой.',

            // email
            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Поле "Email" должно быть действительным электронным адресом.',
            'email.unique' => 'Такой email уже зарегистрирован.',
        ];
    }

    public function toDto(): UserDTO
    {
        return UserDTO::fromData($this->validated());
    }

}
