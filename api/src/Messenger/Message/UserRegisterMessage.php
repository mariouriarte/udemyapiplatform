<?php

declare(strict_types=1);

namespace App\Messenger\Message;

class UserRegisterMessage
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $token
    ) {
    }
}
