<?php

namespace Domain\Dto\Category;

use Domain\Entity\Category;

interface CategoryDtoInterface
{
    function setName(string $name): self;
    function getName(): string;
    
    function getParentUuid(): ?string;
    function setParentUuid(?string $parentUuid): self;
}
