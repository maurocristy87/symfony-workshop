<?php

namespace Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Repository\PurchaseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PurchaseRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Purchase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $total;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="purchases")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseProduct::class, mappedBy="purchase", orphanRemoval=true)
     */
    private $purchaseProducts;
    
    /**
     * @ORM\PrePersist()
     */
    public function prePersist(): void
    {
        $datetime = new \DateTime();
        
        $this->createdAt = $datetime;
        $this->updatedAt = $datetime;
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
        $this->purchaseProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTotal(): ?float
    {
        return (float) $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

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
     * @return Collection|PurchaseProduct[]
     */
    public function getPurchaseProducts(): Collection
    {
        return $this->purchaseProducts;
    }

    public function addPurchaseProduct(PurchaseProduct $purchaseProduct): self
    {
        if (!$this->purchaseProducts->contains($purchaseProduct)) {
            $this->purchaseProducts[] = $purchaseProduct;
            $purchaseProduct->setPurchase($this);
        }

        return $this;
    }

    public function removePurchaseProduct(PurchaseProduct $purchaseProduct): self
    {
        if ($this->purchaseProducts->removeElement($purchaseProduct)) {
            // set the owning side to null (unless already changed)
            if ($purchaseProduct->getPurchase() === $this) {
                $purchaseProduct->setPurchase(null);
            }
        }

        return $this;
    }
}
