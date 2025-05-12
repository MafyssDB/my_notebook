<?php

namespace App\Models\Finance\Operation;

use App\Models\Finance\Category\ExpenseCategory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Operation
{
    protected $table = 'expenses';

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }
}
