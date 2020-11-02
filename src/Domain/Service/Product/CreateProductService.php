<?php

declare(strict_types=1);

namespace Domain\Service\Product;

use Domain\Dto\Product\ProductDtoInterface;
use Domain\Entity\Product;
use Domain\Repository\ProductRepositoryInterface;

interface CreateProductServiceInterface
{
    function create(ProductDtoInterface $dto): Product;
}

class CreateProductService implements CreateProductServiceInterface
{
    private ProductRepositoryInterface $productRepository;
    
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function create(ProductDtoInterface $dto): Product
    {
        $product = (new Product())
            ->setName($dto->getName())
            ->setCategory($dto->getCategory())
            ->setDescription($dto->getDescription())
            ->setImage($dto->getImage())
            ->setPrice($dto->getPrice())
        ;
        
        $this->productRepository->persist($product);
        
        return $product;
    }
}
