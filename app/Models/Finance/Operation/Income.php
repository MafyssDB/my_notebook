<?php

namespace App\Models\Finance\Operation;

use App\Models\Finance\Category\IncomeCategory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Operation
{
    protected $table = 'incomes';

    public function category(): BelongsTo
    {
        return $this->belongsTo(IncomeCategory::class, 'category_id');
    }
}
