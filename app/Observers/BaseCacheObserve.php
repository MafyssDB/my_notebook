<?php

namespace App\Observers;

use App\Helpers\CacheKeyHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

abstract class BaseCacheObserve
{
    public function created(Model $model): void
    {
        $this->refreshCache($model);
    }

    public function updated(Model $model): void
    {
        $this->refreshCache($model);
    }

    public function deleted(Model $model): void
    {
        $this->refreshCache($model, true);
    }

    protected function refreshCache(Model $model, bool $isDelete = false): void
    {
        $key = CacheKeyHelper::getKeyOneById($model);
        if ($isDelete) {
            Cache::forget($key);
        } else {
            Cache::put($key, $model, 3600);
        }
        $this->flushLists($model);
    }

    protected function flushLists(Model $model): void
    {
        $cursor = 0;
        $keys = [];
        do {
            list($cursor, $foundKeys) = Redis::scan($cursor, ['match' => CacheKeyHelper::getPatternList($model), 'count' => 100]);
            $keys = array_merge($keys, $foundKeys);
        } while ($cursor != 0);
        $keysToDelete = array_map(function ($key){
            return str_replace('my_notebook:', '', $key);
        }, $keys);

        if (!empty($keysToDelete)) {
            Redis::del(...$keysToDelete);
        }

        Cache::forget(CacheKeyHelper::getKeyAll($model));
    }
}
