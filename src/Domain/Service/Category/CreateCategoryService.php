<?php

declare(strict_types=1);

namespace Domain\Service\Category;

use Domain\Entity\Category;
use Domain\Dto\Category\CategoryDtoInterface;
use Domain\Repository\CategoryRepositoryInterface;

interface CreateCategoryServiceInterface
{
    function create(CategoryDtoInterface $dto): Category;
}

class CreateCategoryService implements CreateCategoryServiceInterface
{
    private CategoryRepositoryInterface $categoryRepository;
    
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(CategoryDtoInterface $dto): Category
    {
        $parent = $dto->getParentUuid() !== null
            ? $this->categoryRepository->findOneBy(['uuid' => $dto->getParentUuid()])
            : null
        ;
        
        $category = (new Category())
            ->setName($dto->getName())
            ->setParent($parent)
        ;
        
        $this->categoryRepository->persist($category);
        
        return $category;
    }
}
