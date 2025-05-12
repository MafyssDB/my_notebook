<?php

namespace App\DTO\Finance;

use Carbon\Carbon;

class OperationFilterDTO
{
    public function __construct(
        public readonly Carbon $from,
        public readonly Carbon $to,
        public readonly ?int $offset,
        public readonly ?int $limit
    )
    {
    }

    public static function fromData(array $data): static
    {
        return new static(
            $data['from'],
            $data['to'],
            $data['offset'] ?? null,
            $data['limit'] ?? null,
        );
    }
}
