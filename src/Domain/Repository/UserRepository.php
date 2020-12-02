<?php

namespace Domain\Repository;

use Domain\Exception\UserDuplicatedException;
use Domain\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface UserRepositoryInterface {
    function find($id, $lockMode = null, $lockVersion = null);
    function findOneBy(array $criteria, array $orderBy = null);
    function findAll();
    function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
    function persist(User $user, bool $flush = true): void;
}

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
    
    public function persist(User $user, bool $flush = true): void
    {
        try {
            if ($user->getId() === null) {
                $this->getEntityManager()->persist($user);
            }

            if ($flush) {
                $this->getEntityManager()->flush();
            }
        } catch (UniqueConstraintViolationException $ex) {
            throw new UserDuplicatedException();
        }
        
    }
}
