<?php

namespace App\DTO\Finance;

class CategoryDTO
{
    public function __construct(
        public readonly string $name,
    )
    {
    }

    public static function fromData(array $data): static
    {
        return new static(
            $data['name'],
        );
    }
}
