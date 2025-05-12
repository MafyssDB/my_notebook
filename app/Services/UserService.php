<?php

namespace App\Services;

use App\DTO\EmailCodeRequestDTO;
use App\DTO\UserDTO;
use App\Exceptions\InvalidConfirmationCodeException;
use App\Models\User;
use App\Notifications\EmailVerificationCode;
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
    public function register(UserDTO $userDTO)
    {
        $user = $this->userRepository->create($userDTO);
        $this->sendConfirmCode($user, EmailVerificationCode::class);
        return $user;
    }

    /**
     * @throws InvalidConfirmationCodeException
     */
    public function verifyEmail(EmailCodeRequestDTO $dto): void
    {
        $user = $this->userRepository->findUserByEmail($dto->email);
        $this->isConfirmCodeValid($user->id, $dto->code);
        $user->markEmailAsVerified();
        $this->userRepository->forgetConfirmCodeById($user->id);
    }

    /**
     * @throws RandomException
     */
    public function sendLoginCode(string $email)
    {
        $user = $this->userRepository->findUserByEmail($email);
        $this->sendConfirmCode($user, LoginCode::class);
        return $user;
    }

    /**
     * @throws InvalidConfirmationCodeException
     */
    public function login(EmailCodeRequestDTO $dto)
    {
        $user = $this->userRepository->findUserByEmail($dto->email);
        $this->isConfirmCodeValid($user->id, $dto->code);
        $this->userRepository->forgetConfirmCodeById($user->id);
        return $user;
    }

    /**
     * @throws RandomException
     */
    public function resendConfirmCode(string $email, string $notificationClass): void
    {
        $user = $this->userRepository->findUserByEmail($email);
        $this->sendConfirmCode($user, $notificationClass);
    }

    // ----------------- UTILITIES ------------------ //

    /**
     * @throws RandomException
     */
    private function sendConfirmCode(User $user, string $notificationClass): void
    {
        $code = $this->generateConfirmCode($user);
        $user->notify(new $notificationClass($code));
    }

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
