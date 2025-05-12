<?php

namespace App\DTO;

class UserDTO
{
    public function __construct(
        public string $email,
        public string $name,
    )
    {
    }

    public static function fromData(array $data): static
    {
        return new static(
            $data['email'],
            $data['name'],
        );
    }
}
