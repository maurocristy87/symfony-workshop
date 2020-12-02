<?php

namespace Domain\Repository;

use Domain\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface ProductRepositoryInterface {
    function find($id, $lockMode = null, $lockVersion = null);
    function findOneBy(array $criteria, array $orderBy = null);
    function findAll();
    function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
    
    function persist(Product $product, bool $flush = true): void;
    function remove(Product $product): void;
    function flush(): void;
}

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
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

    public function remove(Product $product): void
    {
        $this->getEntityManager()->remove($product);
        $this->getEntityManager()->flush();
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

}
