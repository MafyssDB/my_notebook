<?php

namespace App\Repositories\Finance\Category;

use App\DTO\Finance\CategoryDTO;
use App\Helpers\CacheKeyHelper;
use App\Models\Finance\Category\Category;
use Illuminate\Support\Facades\Cache;


abstract class CategoryRepository
{
    /**
     * @var class-string<Category>
     */
    protected static string $modelClass;

    public function getAll()
    {
       return Cache::rememberForever(CacheKeyHelper::getKeyAll($this::$modelClass), function () {
            return $this::$modelClass::query()->where('user_id', auth()->id())->get();
       });
    }

    public function create(CategoryDTO $dto)
    {
        return $this::$modelClass::query()->create([
            'user_id' => auth()->id(),
            'name' => $dto->name,
        ]);
    }

    public function getOne(string $id)
    {
        return Cache::rememberForever(CacheKeyHelper::getKeyOneById($this::$modelClass, $id), function () use ($id) {
            return $this->findOneById($id);
        });
    }

    public function update(CategoryDTO $dto, string $id)
    {
        $category = $this->findOneById($id);
        $category->update([
            'name' => $dto->name,
        ]);
        return $category;
    }

    public function delete(string $id): void
    {
        $category = $this->findOneById($id);
        $category->delete();
    }

    public function findOneById(string $id)
    {
        return $this::$modelClass::query()->where('user_id', auth()->id())->findOrFail($id);
    }

}
