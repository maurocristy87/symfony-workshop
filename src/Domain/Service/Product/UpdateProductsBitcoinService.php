<?php

declare(strict_types=1);

namespace Domain\Service\Product;

use Domain\Repository\ProductRepositoryInterface;
use Domain\Service\BitcoinConverter\BitcoinConverterInterface;

interface UpdateProductsBitcoinServiceInterface
{
    function update(): void;
}

class UpdateProductsBitcoinService implements UpdateProductsBitcoinServiceInterface
{
    private ProductRepositoryInterface $productRepository;
    
    private BitcoinConverterInterface $bitcoinConverter;
    
    public function __construct(ProductRepositoryInterface $productRepository, BitcoinConverterInterface $bitcoinConverter)
    {
        $this->productRepository = $productRepository;
        $this->bitcoinConverter = $bitcoinConverter;
    }

    public function update(): void
    {
        $products = $this->productRepository->findAll();
        
        /** @var \Domain\Entity\Product $product */
        foreach ($products as $product) {
            $product->setBitcoinPrice($this->bitcoinConverter->ars2btc($product->getPrice()));
        }

        $this->productRepository->flush();
    }
}
