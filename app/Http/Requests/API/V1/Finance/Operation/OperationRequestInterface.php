<?php

namespace App\Http\Requests\API\V1\Finance\Operation;

use App\DTO\Finance\OperationDTO;

interface OperationRequestInterface
{
    public function toDto(): OperationDto;
}
