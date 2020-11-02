<?php

namespace Domain\Repository;

use Domain\Entity\Purchase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

interface ProductRepositoryInterface {
    function persist(Product $product, bool $flush = true): void;
}

/**
 * @method Purchase|null find($id, $lockMode = null, $lockVersion = null)
 * @method Purchase|null findOneBy(array $criteria, array $orderBy = null)
 * @method Purchase[]    findAll()
 * @method Purchase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Purchase::class);
    }
    
    public function persist(Product $product, bool $flush = true): void
    {
        if ($product->getId() === null) {
            $this->getEntityManager()->persist($product);
        }
        
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
