<?php

namespace App\Repositories\Finance\Category;

use App\Models\Finance\Category\ExpenseCategory;

class ExpenseCategoryRepository extends CategoryRepository
{
    protected static string $modelClass = ExpenseCategory::class;

}
