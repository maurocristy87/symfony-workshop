<?php

namespace Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"create", "show"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"create", "show"})
     */
    private $uuid;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"create", "show"})
     */
    private $price;
    
    /**
     * @ORM\Column(type="decimal", precision=12, scale=10, nullable=true)
     * @Groups({"create", "show"})
     */
    private $bitcoinPrice;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"create", "show"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"create", "show"})
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=ProductAttribute::class, mappedBy="product", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Groups({"create", "show"})
     */
    private $productAttributes;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;
    
    /**
     * @ORM\PrePersist()
     */
    public function prePersist(): void
    {
        $datetime = new \DateTime();
        
        $this->createdAt = $datetime;
        $this->updatedAt = $datetime;
        
        $this->uuid = (Uuid::uuid4())->toString();
    }
    
    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function __construct()
    {
        $this->productAttributes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|ProductAttribute[]
     */
    public function getProductAttributes(): Collection
    {
        return $this->productAttributes;
    }

    public function addProductAttribute(ProductAttribute $productAttribute): self
    {
        if (!$this->productAttributes->contains($productAttribute)) {
            $this->productAttributes[] = $productAttribute;
            $productAttribute->setProduct($this);
        }

        return $this;
    }

    public function removeProductAttribute(ProductAttribute $productAttribute): self
    {
        if ($this->productAttributes->removeElement($productAttribute)) {
            // set the owning side to null (unless already changed)
            if ($productAttribute->getProduct() === $this) {
                $productAttribute->setProduct(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getBitcoinPrice(): ?float
    {
        return $this->bitcoinPrice;
    }

    public function setBitcoinPrice(?float $bitcoinPrice): self
    {
        $this->bitcoinPrice = $bitcoinPrice;

        return $this;
    }
}
