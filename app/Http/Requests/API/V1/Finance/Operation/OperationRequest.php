<?php

namespace App\Http\Requests\API\V1\Finance\Operation;

use App\DTO\Finance\OperationDTO;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

abstract class OperationRequest extends FormRequest implements OperationRequestInterface
{

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|min:3|max:255',
            'date_operation' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Поле "Сумма" обязательно для заполнения.',
            'amount.numeric' => 'Поле "Сумма" должно быть числом.',
            'amount.min' => 'Поле "Сумма" не может быть меньше 0.',

            'description.required' => 'Поле "Описание" обязательно для заполнения.',
            'description.string' => 'Поле "Описание" должно быть строкой.',
            'description.min' => 'Поле "Описание" должно содержать не менее 3 символов.',
            'description.max' => 'Поле "Описание" не должно превышать 255 символов.',

            'category_id.required' => 'Поле "Категория" обязательно для заполнения.',
            'category_id.integer' => 'Поле "Категория" должно быть целым числом.',
            'category_id.exists' => 'Выбранная категория не существует.',

            'date_operation.required' => 'Поле "Дата операции" обязательно для заполнения.',
            'date_operation.date' => 'Поле "Дата операции" должно быть корректной датой.',
        ];
    }


    public function toDto(): OperationDTO
    {
        $data = $this->validated();
        $data['date_operation'] = Carbon::parse($data['date_operation']);
        return OperationDTO::fromData($data);
    }

}
