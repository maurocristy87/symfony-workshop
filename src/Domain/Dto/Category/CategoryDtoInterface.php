<?php

namespace Domain\Dto\Category;

use Domain\Entity\Category;

interface CategoryDtoInterface
{
    function setName(string $name): void;
    function getName(): string;
    
    function getParent(): ?Category;
    function setParent(Category $category);
}
