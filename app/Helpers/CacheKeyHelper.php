<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class CacheKeyHelper
{
    public static function getKeyAll(Model|string $model): string
    {
        return self::getBaseKey($model) . '_all';
    }

    public static function getKeyOneById(Model|string $model, string|int $id = null): string
    {
        $id = $id ?? $model->id;
        return self::getBaseKey($model) . '_' . $id;
    }

    public static function getListKey(Model|string $model, string $subKey = ''): string
    {
        $baseKey = self::getBaseKey($model);
        $hash = md5(json_encode([Request::all(), $subKey]));
        return "{$baseKey}_list_{$hash}";
    }

    public static function getPatternList(Model|string $model): string
    {
        return 'my_notebook:' . self::getBaseKey($model) . '_list_*';
    }

    private static function getBaseKey(Model|string $model): string
    {
        return Str::snake(class_basename($model)) . '_user_' . auth()->id();
    }


}
