<?php

declare(strict_types=1);

namespace Domain\Service\Product;

use Domain\Dto\Product\ProductDtoInterface;
use Domain\Entity\Product;
use Domain\Exception\ServiceValidationException;
use Domain\Repository\ProductRepositoryInterface;
use Domain\Repository\CategoryRepositoryInterface;

interface CreateProductServiceInterface
{
    function create(ProductDtoInterface $dto): Product;
}

class CreateProductService implements CreateProductServiceInterface
{
    private ProductRepositoryInterface $productRepository;
    
    private CategoryRepositoryInterface $categoryRepository;
    
    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function create(ProductDtoInterface $dto): Product
    {
        $category = $this->categoryRepository->findOneBy(['uuid' => $dto->getCategoryUuid()]);
        if ($category === null) {
            throw new ServiceValidationException(sprintf('Category with uuid %s not found', $dto->getCategoryUuid()));
        }
        
        $product = (new Product())
            ->setName($dto->getName())
            ->setCategory($category)
            ->setDescription($dto->getDescription())
            ->setImage($dto->getImage())
            ->setPrice($dto->getPrice())
        ;
        
        $this->productRepository->persist($product);
        
        return $product;
    }
}
