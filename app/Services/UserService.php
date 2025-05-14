<?php

namespace App\Services;

use App\DTO\EmailCodeRequestDTO;
use App\DTO\UserDTO;
use App\Exceptions\InvalidConfirmationCodeException;
use App\Models\User;
use App\Notifications\LoginCode;
use App\Repositories\UserRepository;
use Random\RandomException;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
    )
    {
    }

    /**
     * @throws RandomException
     */
    public function register(UserDTO $userDTO): void
    {
        $this->userRepository->create($userDTO);
    }

    /**
     * @throws RandomException
     */
    public function sendLoginCode(string $email)
    {
        $user = $this->userRepository->findUserByEmail($email);
        $code = $this->generateConfirmCode($user);
        $user->notify(new LoginCode($code));
        return $user;
    }

    /**
     * @throws InvalidConfirmationCodeException
     */
    public function login(EmailCodeRequestDTO $dto)
    {
        $user = $this->userRepository->findUserByEmail($dto->email);
        $this->isConfirmCodeValid($user->id, $dto->code);
        if (!$user->hasVerifiedEmail()){
            $user->markEmailAsVerified();
        }
        $this->userRepository->forgetConfirmCodeById($user->id);
        return $user;
    }

    // ----------------- UTILITIES ------------------ //

    /**
     * @throws RandomException
     */
    private function generateConfirmCode(User $user): int
    {
        $code = random_int(100000, 999999);
        $this->userRepository->setConfirmCodeById($user->id, $code);
        return $code;
    }

    /**
     * @throws InvalidConfirmationCodeException
     */
    private function isConfirmCodeValid(int $userId, string $code): void
    {
        $validCode = $this->userRepository->getConfirmCodeById($userId);
        if ((string) $validCode !== $code) {
            throw new InvalidConfirmationCodeException();
        }
    }

}
