<?php

declare(strict_types=1);

namespace App\Service\Password;

use App\Entity\User;
use App\Exceptions\Password\PasswordException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class EncoderService
{
    private const MINIMUM_LENGTH = 6;

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function generateEncoderPassword(PasswordAuthenticatedUserInterface $user, string $plainPassword)
    {
        if (self::MINIMUM_LENGTH > \strlen($plainPassword)) {
            throw PasswordException::invalidLenght();
        }

        return $this->passwordHasher->hashPassword($user,$plainPassword);
    }

    public function isValidPassword(User $user, string $oldPassword): bool
    {
        return $this->passwordHasher->isPasswordValid($user, $oldPassword);
    }
}
