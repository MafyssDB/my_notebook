<?php

namespace App\Models\Finance\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
    ];
}
