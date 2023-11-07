<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserAccountantAlreadyExistException extends ConflictHttpException
{
    private const MSG = 'User with email %s already exist';

    public static function fromEmail(string $email): self
    {
        throw new self(\sprintf(self::MSG, $email));
    }
}
