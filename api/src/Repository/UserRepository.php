<?php

namespace App\Repository;

use App\Entity\User;
use App\Exceptions\User\UserNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneByEmailOrFail(string $email): User
    {
        $user = $this->findOneBy(['email' => $email]);
        if (!$user) {
            UserNotFoundException::fromEmail($email);
        }

        return $user;
    }

    public function save(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function remove(User $user): void
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }
}
