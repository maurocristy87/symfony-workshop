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
    function findProductsByFilters(int $page = 1, int $perPage = 5, array $filters = []): array;
    
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
    use RepositoryCacheTrait;
    
    private int $cacheLifetime;
    
    public function __construct(ManagerRegistry $registry, int $cacheLifetime)
    {
        parent::__construct($registry, Product::class);
        $this->cacheLifetime = $cacheLifetime;
    }
    
    public function findProductsByFilters(int $page = 1, int $perPage = 5, array $filters = []): array
    {
        $qb = $this->createQueryBuilder('p');
        
        if (array_key_exists('search', $filters)) {
            $qb->andWhere('p.name LIKE :search')
                ->setParameter('search', '%' . $filters['search'] . '%')
            ;
        }
        
        if (array_key_exists('category', $filters)) {
            $qb->join('p.category', 'c')
                ->andWhere('c.uuid = :category')
                ->setParameter('category', $filters['category']) // $filters['category'] has the category uuid
            ;
        }
        
        if (array_key_exists('minPrice', $filters)) {
            $qb->andWhere('p.price >= :minPrice')
                ->setParameter('minPrice', $filters['minPrice'])
            ;
        }
        
        if (array_key_exists('maxPrice', $filters)) {
            $qb->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice', $filters['maxPrice'])
            ;
        }
        
        $qb->setMaxResults($perPage)
            ->setFirstResult(($page -1 ) * $perPage)
        ;
        
        return $qb->getQuery()->enableResultCache('3600', $this->getCacheName(__FUNCTION__))->getResult();
    }
    
    public function persist(Product $product, bool $flush = true): void
    {
        if ($product->getId() === null) {
            $this->getEntityManager()->persist($product);
        }
        
        if ($flush) {
            $this->getEntityManager()->flush();
        }
        
        $this->clearCache('findProductsByFilters');
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
