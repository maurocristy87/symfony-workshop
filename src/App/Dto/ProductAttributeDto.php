<?php

declare(strict_types=1);

namespace App\Dto;

use Domain\Dto\Product\ProductAttributeDtoInterface;

class ProductAttributeDto implements ProductAttributeDtoInterface
{
    private int $attributeId;
    
    private string $value;
    
    public function getAttributeId(): int
    {
        return $this->attributeId;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setAttributeId(int $attributeId): self
    {
        $this->attributeId = $attributeId;
        
        return $this;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;
        
        return $this;
    }

}
