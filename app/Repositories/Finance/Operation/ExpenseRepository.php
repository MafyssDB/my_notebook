<?php

namespace App\Repositories\Finance\Operation;


use App\Models\Finance\Operation\Expense;

class ExpenseRepository extends OperationRepository
{
    protected static string $modelClass = Expense::class;
}
