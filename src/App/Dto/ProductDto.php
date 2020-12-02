<?php

declare(strict_types=1);

namespace App\Dto;

use Domain\Dto\Product\ProductDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ProductDto implements ProductDtoInterface
{
    /**
     * @Assert\Uuid
     * @Assert\NotBlank
     */
    private string $categoryUuid;
    
    /**
     * @Assert\Type("string")
     */
    private ?string $image = null;
    
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    private string $name;
    
    /**
     * @Assert\Type("string")
     * @Assert\Length(min=1, max=1000)
     */
    private ?string $description = null;
    
    /**
     * @Assert\Type("float")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value=0.01)
     */
    private float $price;
    
    /**
     * @var ProductAttributeDto[]
     */
    private array $productAttributes;
    
    public function getCategoryUuid(): string
    {
        return $this->categoryUuid;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setCategoryUuid(string $categoryUuid): void
    {
        $this->categoryUuid = $categoryUuid;
    }

    public function setImage(?string $image = null): void
    {
        $this->image = $image;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(?string $description = null): void
    {
        $this->description = $description;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getProductAttributes(): array
    {
        return $this->productAttributes;
    }

    public function setProductAttributes(array $productAttributes): self
    {
        $this->productAttributes = $productAttributes;
        
        return $this;
    }
}
