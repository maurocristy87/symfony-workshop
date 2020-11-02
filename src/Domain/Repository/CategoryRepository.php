<?php

namespace Domain\Repository;

use Domain\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


interface CategoryRepositoryInterface {
    function persist(Category $category, boolean $flush = true);
}

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function persist(Category $category, bool $flush = true): void
    {
        if ($category->getId() === null) {
            $this->getEntityManager()->persist($category);
        }
        
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
