<?php

declare(strict_types=1);

namespace Domain\Factory;

use Domain\Entity\Product;
use Domain\Entity\ProductAttribute;
use Domain\Exception\ServiceValidationException;
use Domain\Dto\Product\ProductDtoInterface;
use Domain\Dto\Product\ProductAttributeDtoInterface;
use Domain\Repository\AttributeRepositoryInterface;
use Domain\Repository\CategoryRepositoryInterface;

class ProductFactory
{
    private AttributeRepositoryInterface $attributeRepository;
    
    private CategoryRepositoryInterface $categoryRepository;
    
    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function create(ProductDtoInterface $dto): Product
    {
        $product = new Product();
        
        $this->update($product, $dto);
        
        return $product;
    }
    
    public function update(Product $product, ProductDtoInterface $dto): void
    {
        $category = $this->categoryRepository->findOneBy(['uuid' => $dto->getCategoryUuid()]);
        if ($category === null) {
            throw new ServiceValidationException(sprintf('Category with uuid %s not found', $dto->getCategoryUuid()));
        }
        
        $product
            ->setName($dto->getName())
            ->setCategory($category)
            ->setDescription($dto->getDescription())
            ->setImage($dto->getImage())
            ->setPrice($dto->getPrice())
        ;
        
        foreach ($product->getProductAttributes() as $productAttribute) {
            $product->removeProductAttribute($productAttribute);
        }
        
        foreach ($dto->getProductAttributes() as $productAttributeDto) {
            $this->addProductAttribute($product, $productAttributeDto);
        }
    }
    
    private function addProductAttribute(Product $product, ProductAttributeDtoInterface $dto): void
    {
        $attribute = $this->attributeRepository->find($dto->getAttributeId());
        if ($attribute === null) {
            throw new ServiceValidationException(sprintf('Attribute with id %s not found', $dto->getAttributeId()));
        }
        
        $productAttribute = (new ProductAttribute())
            ->setAttribute($attribute)
            ->setValue($dto->getValue())
        ;
        
        $product->addProductAttribute($productAttribute);
    }
}
