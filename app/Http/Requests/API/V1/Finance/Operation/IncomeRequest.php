<?php

namespace App\Http\Requests\API\V1\Finance\Operation;

class IncomeRequest extends OperationRequest
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
        return array_merge(parent::rules(), [
            'category_id' => 'required|integer|exists:income_categories,id',
        ]);
    }

}
