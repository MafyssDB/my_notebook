<?php

namespace App\Models\Finance\Operation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'description',
        'date_operation',
    ];

    protected $casts = [
        'date_operation' => 'date',
    ];
}
