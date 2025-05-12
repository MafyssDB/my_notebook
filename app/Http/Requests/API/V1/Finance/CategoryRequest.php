<?php

namespace App\Http\Requests\API\V1\Finance;

use App\DTO\Finance\CategoryDTO;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|string|max:50|min:3',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.string'   => 'Поле "Имя" должно быть строкой.',
            'name.max'      => 'Поле "Имя" не должно превышать 50 символов.',
            'name.min'      => 'Поле "Имя" должно содержать не менее 3 символов.',
        ];
    }

    public function toDto(): CategoryDTO
    {
        return CategoryDTO::fromData($this->validated());
    }
}
