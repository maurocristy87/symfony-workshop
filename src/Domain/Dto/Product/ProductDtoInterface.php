<?php

namespace Domain\Dto\Product;

use Domain\Entity\Category;

interface ProductDtoInterface
{
    function getName(): string;
    function setName(string $name): void;
    
    function getDescription(): ?string;
    function setDescription(?string $description): void;
    
    function getPrice(): float;
    function setPrice(float $price);
    
    function getImage(): ?string;
    function setImage(?string $image);
    
    function getCategoryUuid(): string;
    function setCategoryUuid(string $categoryUuid);
}
