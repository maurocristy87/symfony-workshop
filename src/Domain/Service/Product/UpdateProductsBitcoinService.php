<?php

declare(strict_types=1);

namespace Domain\Service\Product;

use Domain\Repository\ProductRepositoryInterface;
use Domain\Service\BitcoinConverter\BitcoinConverterInterface;
use Domain\Service\Logger\CustomLoggerInterface;

interface UpdateProductsBitcoinServiceInterface
{
    function update(): void;
}

class UpdateProductsBitcoinService implements UpdateProductsBitcoinServiceInterface
{
    private ProductRepositoryInterface $productRepository;
    
    private BitcoinConverterInterface $bitcoinConverter;
    
    private CustomLoggerInterface $logger;
    
    public function __construct(
        ProductRepositoryInterface $productRepository,
        BitcoinConverterInterface $bitcoinConverter,
        CustomLoggerInterface $logger
    ) {
        $this->productRepository = $productRepository;
        $this->bitcoinConverter = $bitcoinConverter;
        $this->logger = $logger;
    }

    public function update(): void
    {
        try {
            $products = $this->productRepository->findAll();
        
            /** @var \Domain\Entity\Product $product */
            foreach ($products as $product) {
                $product->setBitcoinPrice($this->bitcoinConverter->ars2btc($product->getPrice()));
            }

            $this->productRepository->flush();
            
            $this->logger->debug('Debug log');
            $this->logger->info('Bitcoin prices updated');
        } catch (\Exception $ex) {
            $this->logger->error('Something wrong happened: ' . $ex->getMessage());
        }
    }
}
