<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\UserAccountant;
use App\Repository\UserAccountantRepository;
use App\Service\Password\EncoderService;
use App\Service\Request\RequestService;
use Symfony\Component\HttpFoundation\Request;

class UserRegisterService
{
    public function __construct(
        private readonly UserAccountantRepository $userRepository,
        private readonly EncoderService $encoderService
    ) {
    }

    public function create(Request $request): UserAccountant
    {
        $names = RequestService::getField($request, 'names');
        $email = RequestService::getField($request, 'email');
        $password = RequestService::getField($request, 'password');

        $user = new UserAccountant($names, $email);

        $user->setPassword($this->encoderService->generateEncoderPassword($user, $password));

//        try {
            $this->userRepository->save($user);
//        } catch (\Exception $e) {
//            echo($e->getMessage());
////            throw UserAlreadyExistException::fromEmail($email);
//        }

        return $user;
    }
}
