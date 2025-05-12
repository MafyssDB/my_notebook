<?php

namespace App\Repositories\Finance\Operation;


use App\Models\Finance\Operation\Income;

class IncomeRepository extends OperationRepository
{
    protected static string $modelClass = Income::class;

}
