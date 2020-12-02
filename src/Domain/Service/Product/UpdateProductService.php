<?php

declare(strict_types=1);

namespace Domain\Service\Product;

use Domain\Dto\Product\ProductDtoInterface;
use Domain\Entity\Product;
use Domain\Factory\ProductFactory;
use Domain\Repository\ProductRepositoryInterface;

interface UpdateProductServiceInterface
{
    function update(Product $product, ProductDtoInterface $dto): Product;
}

class UpdateProductService implements UpdateProductServiceInterface
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

    public function update(Product $product, ProductDtoInterface $dto): Product
    {
        $this->productFactory->update($product, $dto);
        
        $this->productRepository->persist($product);
        
        return $product;
    }
}
