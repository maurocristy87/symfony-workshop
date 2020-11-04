<?php

declare(strict_types=1);

namespace App\Dto;

use Domain\Dto\Category\CategoryDtoInterface;

class CategoryDto implements CategoryDtoInterface
{
    private string $name;
    
    private ?string $parentUuid;
    
    public function getName(): string
    {
        return $this->name;
    }

    public function getParentUuid(): ?string
    {
        return $this->parentUuid;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        
        return $this;
    }

    public function setParentUuid(?string $parentUuid): self
    {
        $this->parentUuid = $parentUuid;
        
        return $this;
    }
}
