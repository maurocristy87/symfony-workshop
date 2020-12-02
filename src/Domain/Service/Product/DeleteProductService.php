<?php

declare(strict_types=1);

namespace Domain\Service\Product;

use Domain\Entity\Product;
use Domain\Repository\ProductRepositoryInterface;

interface DeleteProductServiceInterface {
    function delete(Product $product): void;
}

class DeleteProductService implements DeleteProductServiceInterface
{
    private ProductRepositoryInterface $productRepository;
    
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    
    public function delete(Product $product): void
    {
        $this->productRepository->remove($product);
    }
}
