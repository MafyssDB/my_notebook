<?php

namespace App\Repositories;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserRepository
{
    // -------------------- CRUD -------------------- //
    public function create(UserDTO $userDTO)
    {
        return User::query()->create([
            'email' => $userDTO->email,
            'name' => $userDTO->name,
        ]);
    }

    // -------------------- FIND -------------------- //
    public static function findUserByEmail(string $email)
    {
        return User::query()->where('email', $email)->first();
    }

    // -------------------- CACHE -------------------- //
    public function setConfirmCodeById(int $id, int $code): void
    {
        Cache::put(User::USER_CONFIRM_CODE_CACHE_PREFIX . $id, $code, 180);
    }

    public function getConfirmCodeById(int $id)
    {
        return Cache::get(User::USER_CONFIRM_CODE_CACHE_PREFIX . $id);
    }

    public function forgetConfirmCodeById(int $id): void
    {
        Cache::forget(User::USER_CONFIRM_CODE_CACHE_PREFIX . $id);
    }
}
