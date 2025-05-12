<?php

namespace App\Providers;

use App\Http\Controllers\API\V1\Finance\Category\ExpenseCategoryController;
use App\Http\Controllers\API\V1\Finance\Category\IncomeCategoryController;
use App\Http\Controllers\API\V1\Finance\Operation\ExpenseController;
use App\Http\Controllers\API\V1\Finance\Operation\IncomeController;
use App\Http\Requests\API\V1\Finance\Operation\ExpenseRequest;
use App\Http\Requests\API\V1\Finance\Operation\IncomeRequest;
use App\Http\Requests\API\V1\Finance\Operation\OperationRequest;
use App\Models\Finance\Category\ExpenseCategory;
use App\Models\Finance\Category\IncomeCategory;
use App\Models\Finance\Operation\Expense;
use App\Models\Finance\Operation\Income;
use App\Observers\Finance\Category\ExpenseCategoryCacheObserve;
use App\Observers\Finance\Category\IncomeCategoryCacheObserve;
use App\Observers\Finance\Operation\ExpenseCacheObserve;
use App\Observers\Finance\Operation\IncomeCacheObserve;
use App\Repositories\Finance\Category\CategoryRepository;
use App\Repositories\Finance\Category\ExpenseCategoryRepository;
use App\Repositories\Finance\Category\IncomeCategoryRepository;
use App\Repositories\Finance\Operation\ExpenseRepository;
use App\Repositories\Finance\Operation\IncomeRepository;
use App\Repositories\Finance\Operation\OperationRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(IncomeCategoryController::class)
            ->needs(CategoryRepository::class)
            ->give(IncomeCategoryRepository::class);

        $this->app->when(ExpenseCategoryController::class)
            ->needs(CategoryRepository::class)
            ->give(ExpenseCategoryRepository::class);



        $this->app->when(IncomeController::class)
            ->needs(OperationRepository::class)
            ->give(IncomeRepository::class);

        $this->app->when(ExpenseController::class)
            ->needs(OperationRepository::class)
            ->give(ExpenseRepository::class);

        $this->app->when(IncomeRepository::class)
            ->needs(CategoryRepository::class)
            ->give(IncomeCategoryRepository::class);

        $this->app->when(ExpenseRepository::class)
            ->needs(CategoryRepository::class)
            ->give(ExpenseCategoryRepository::class);

        $this->app->bind(OperationRequest::class, function () {
            if (request()->is('api/v1/incomes', 'api/v1/incomes/*')) {
                return new IncomeRequest();
            }
            return new ExpenseRequest();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        IncomeCategory::observe(IncomeCategoryCacheObserve::class);
        ExpenseCategory::observe(ExpenseCategoryCacheObserve::class);
        Income::observe(IncomeCacheObserve::class);
        Expense::observe(ExpenseCacheObserve::class);
    }
}
