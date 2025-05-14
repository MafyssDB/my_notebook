<?php

use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\Finance\Category\ExpenseCategoryController;
use App\Http\Controllers\API\V1\Finance\Category\IncomeCategoryController;
use App\Http\Controllers\API\V1\Finance\Operation\ExpenseController;
use App\Http\Controllers\API\V1\Finance\Operation\IncomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::prefix('v1')->group(function () {

    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/send-login-code', [AuthController::class, 'sendLoginCode'])->name('send-login-code');
    Route::post('/login', [AuthController::class, 'login'])->name('login');


    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/logout-all', [AuthController::class, 'logoutAll'])->name('logout-all');

        Route::get('/expenses/summary', [ExpenseController::class, 'summary'])->name('expenses.summary');
        Route::apiResource('expenses', ExpenseController::class);

        Route::get('/incomes/summary', [IncomeController::class, 'summary'])->name('incomes.summary');
        Route::apiResource('incomes', IncomeController::class);

        Route::apiResource('income-categories', IncomeCategoryController::class);
        Route::apiResource('expense-categories', ExpenseCategoryController::class);
    });
});

