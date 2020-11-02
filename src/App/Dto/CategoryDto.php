<?php

declare(strict_types=1);

namespace App\Dto;

use Domain\Dto\Category\CategoryDtoInterface;

class CategoryDto implements CategoryDtoInterface
{
    
    public function getName(): string
    {
        
    }

    public function getParent(): ?\Domain\Entity\Category
    {
        
    }

    public function setName(string $name): void
    {
        
    }

    public function setParent(\Domain\Entity\Category $category)
    {
        
    }

}
