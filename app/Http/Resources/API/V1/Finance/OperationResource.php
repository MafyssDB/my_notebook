<?php

namespace App\Http\Resources\API\V1\Finance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OperationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'description' => $this->description,
            'category' => CategoryResource::make($this->category),
            'date_operation' => $this->date_operation->format('d.m.Y'),
        ];
    }
}
