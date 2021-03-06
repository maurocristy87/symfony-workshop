<?php

declare(strict_types=1);

namespace Domain\Service\Product;

use Domain\Dto\Product\ProductDtoInterface;
use Domain\Entity\Product;
use Domain\Factory\ProductFactory;
use Domain\Repository\ProductRepositoryInterface;
use Domain\Repository\CategoryRepositoryInterface;

interface CreateProductServiceInterface
{
    function create(ProductDtoInterface $dto): Product;
}

class CreateProductService implements CreateProductServiceInterface
{
    private ProductRepositoryInterface $productRepository;
    
    private ProductFactory $productFactory;
    
    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductFactory $productFactory
    ) {
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
    }

    public function create(ProductDtoInterface $dto): Product
    {
        $product = $this->productFactory->create($dto);
        
        $this->productRepository->persist($product);
        
        return $product;
    }
}
