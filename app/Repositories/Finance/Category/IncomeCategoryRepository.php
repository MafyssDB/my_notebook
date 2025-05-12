<?php

namespace App\Repositories\Finance\Category;

use App\Models\Finance\Category\IncomeCategory;

class IncomeCategoryRepository extends CategoryRepository
{
    protected static string $modelClass = IncomeCategory::class;
}
