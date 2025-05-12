<?php

namespace App\Repositories\Finance\Operation;

use App\DTO\Finance\OperationDTO;
use App\DTO\Finance\OperationFilterDTO;
use App\Helpers\CacheKeyHelper;
use App\Models\Finance\Operation\Operation;
use App\Repositories\Finance\Category\CategoryRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

abstract class OperationRepository
{
    /**
     * @var class-string<Operation>
     */
    protected static string $modelClass;

    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    public function getAll(OperationFilterDTO $dto)
    {
        return Cache::rememberForever(CacheKeyHelper::getListKey($this::$modelClass), function () use ($dto) {
            return $this->returnQueryForOperations($dto)
                ->orderByDesc('date_operation')
                ->skip($dto->offset)    // Смещение
                ->take($dto->limit)     // Количество записей
                ->get();
//                ->paginate(3);
        });
    }

    /**
     * @throws ValidationException
     */
    public function create(OperationDTO $dto)
    {
        $this->checkDateOperation($dto);
        return $this::$modelClass::create([
            'amount' => $dto->amount,
            'description' => $dto->description,
            'user_id' => auth()->id(),
            'category_id' => $dto->category_id,
            'date_operation' => $dto->date_operation,
        ]);
    }

    public function getOne(string $id)
    {
        return Cache::rememberForever(CacheKeyHelper::getKeyOneById($this::$modelClass, $id), function () use ($id) {
            return $this->findOneById($id);
        });
    }

    /**
     * @throws ValidationException
     */
    public function update(OperationDTO $dto, string $id)
    {
        $this->checkDateOperation($dto);
        $operation = $this->findOneById($id);
        $operation->update([
            'amount' => $dto->amount,
            'description' => $dto->description,
            'category_id' => $dto->category_id,
            'date_operation' => $dto->date_operation,
        ]);
        return $operation;
    }

    public function delete(string $id): void
    {
        $operation = $this->findOneById($id);
        $operation->delete();
    }

    public function summary(OperationFilterDTO $dto)
    {
        return Cache::rememberForever(CacheKeyHelper::getListKey($this::$modelClass, 'summary'), function () use ($dto) {
            return $this->returnQueryForOperations($dto)
                ->selectRaw('category_id, SUM(amount) as total_amount')
                ->groupBy('category_id')
                ->with(['category:id,name'])
                ->get()
                ->map(function ($item) {
                    return [
                        'category_name' => $item->category->name ?? 'Без категории',
                        'total_amount' => $item->total_amount,
                    ];
                });
        });
    }

    public function findOneById(string $id)
    {
        return $this::$modelClass::query()->where('user_id', auth()->id())->findOrFail($id);
    }

    /**
     * @throws ValidationException
     */
    private function checkDateOperation(OperationDTO $dto): void
    {
        $category = $this->categoryRepository->getOne($dto->category_id);
        if ($category->created_at->format('Y-m-d') > $dto->date_operation->format('Y-m-d')) {
            throw ValidationException::withMessages([
                'date_operation' => [
                    'Дата операции не может быть раньше, чем дата создания категории: ' . $category->created_at->format('d.m.Y'),
                ],
            ]);
        }
    }

    protected function returnQueryForOperations(OperationFilterDTO $dto)
    {
        return $this::$modelClass::query()
            ->where('user_id', auth()->id())
            ->whereBetween('date_operation', [$dto->from->format('Y-m-d'), $dto->to->format('Y-m-d')]);
    }
}
