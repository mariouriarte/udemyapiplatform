<?php

declare(strict_types=1);

namespace App\Controller\Action\User;

use App\Entity\User;
use App\Service\User\UserRegisterService;
use Symfony\Component\HttpFoundation\Request;

class Register
{
    public function __construct(
        private readonly UserRegisterService $userRegisterService
    ) {
    }

    public function __invoke(Request $request): User
    {
        return $this->userRegisterService->create($request);
    }
}
