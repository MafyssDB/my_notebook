<?php

namespace App\DTO\Finance;

use Carbon\Carbon;

class OperationDTO
{
    public function __construct(
        public readonly float $amount,
        // ToDo Узнать, может ставить пустую строку, а не null
        public readonly string|null $description,
        public readonly int $category_id,
        public readonly Carbon $date_operation,
    )
    {
    }

    public static function fromData(array $data): static
    {
        return new static(
            $data['amount'],
            $data['description'],
            $data['category_id'],
            $data['date_operation'],
        );
    }
}
