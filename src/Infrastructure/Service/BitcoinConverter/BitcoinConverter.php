<?php

declare(strict_types=1);

namespace Infrastructure\Service\BitcoinConverter;

use Domain\Exception\ServiceRuntimeException;
use Domain\Service\BitcoinConverter\BitcoinConverterInterface;
use Infrastructure\Service\Cache\CacheServiceInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;

class BitcoinConverter implements BitcoinConverterInterface
{
    private const URL = 'https://api.satoshitango.com/v2/ticker';
    private const CACHE_KEY = 'btc-ars';
    private const CACHE_LIFETIME = 300;
    
    private ClientInterface $httpClient;
    
    private CacheServiceInterface $cache;
    
    public function __construct(ClientInterface $httpClient, CacheServiceInterface $cache)
    {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
    }

    public function ars2btc(float $arsAmount): float
    {
        if ($this->cache->has(self::CACHE_KEY) === false) {
            $this->updateCache();
        } 
        
        return $arsAmount / $this->cache->get(self::CACHE_KEY);
    }
    
    private function updateCache(): void
    {
        try {
            $result = $this->httpClient->request('GET', self::URL);
            $body = (string) $result->getBody();
            $decoded = \json_decode($body, true);
            
            $this->cache->set(self::CACHE_KEY, (float) $decoded['data']['compra']['arsbtc'], self::CACHE_LIFETIME);
            
        } catch (TransferException $e) {
            throw new ServiceRuntimeException('Error requesting Bitcoin conversion: ' . $e->getMessage());
        }
    }
}
