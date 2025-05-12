<?php

namespace App\Http\Requests\API\V1\Finance\Operation;


use App\DTO\Finance\OperationFilterDTO;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'offset' => 'nullable|int',
            'limit' => 'nullable|int',
        ];
    }

    public function toDto(): OperationFilterDTO
    {
        $data = $this->validated();
        if (!array_key_exists('from', $data) && !array_key_exists('to', $data)) {
            $data['from'] = Carbon::now()->startOfMonth();
            $data['to'] = Carbon::now()->endOfMonth();
        }else{
            $data['from'] = Carbon::parse($data['from']);
            $data['to'] = Carbon::parse($data['to']);
        }
        return OperationFilterDTO::fromData($data);
    }
}
