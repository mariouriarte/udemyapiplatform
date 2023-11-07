<?php

namespace App\Repository;

use App\Entity\UserAccountant;
use App\Exceptions\User\UserAccountantNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserAccountant>
 *
 * @method UserAccountant|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAccountant|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAccountant[]    findAll()
 * @method UserAccountant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAccountantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAccountant::class);
    }

    public function findOneByEmailOrFail(string $email): UserAccountant
    {
        $user = $this->findOneBy(['email' => $email]);
        if (!$user) {
            UserAccountantNotFoundException::fromEmail($email);
        }

        return $user;
    }

    public function save(UserAccountant $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function remove(UserAccountant $user): void
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }
}
