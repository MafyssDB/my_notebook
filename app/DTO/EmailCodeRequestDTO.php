<?php

namespace App\DTO;

class EmailCodeRequestDTO
{
    public function __construct(
        public string $code,
        public string $email,
    )
    {
    }

    public static function fromData(array $data): static
    {
        return new static(
            $data['code'],
            $data['email'],
        );
    }
}
