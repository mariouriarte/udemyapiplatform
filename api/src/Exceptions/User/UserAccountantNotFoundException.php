<?php

namespace App\Exceptions\User;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserAccountantNotFoundException extends NotFoundHttpException
{
    private const MSG = 'User with email %s not found';

    public static function fromEmail(string $email): self
    {
        throw new self(\sprintf(self::MSG, $email));
    }
}
