<?php

namespace Domain\Dto\Product;

interface ProductAttributeDtoInterface
{
    public function getAttributeId(): int;
    public function getValue(): string;
    public function setAttributeId(int $attributeId): self;
    public function setValue(string $value): self;
}
