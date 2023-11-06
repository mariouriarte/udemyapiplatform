<?php

declare(strict_types=1);

namespace App\Exceptions\Password;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PasswordException extends BadRequestHttpException
{
    public static function invalidLenght(): self
    {
        throw new self('Password must be at last 6 characters');
    }
}
