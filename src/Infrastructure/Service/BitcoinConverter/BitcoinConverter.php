<?php

declare(strict_types=1);

namespace Infrastructure\Service\BitcoinConverter;

use Domain\Exception\ServiceRuntimeException;
use Domain\Service\BitcoinConverter\BitcoinConverterInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;

class BitcoinConverter implements BitcoinConverterInterface
{
    private const URL = 'https://api.satoshitango.com/v2/ticker';
    
    private ClientInterface $httpClient;
    
    private ?float $cache = null;
    
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function ars2btc(float $arsAmount): float
    {
        try {
            if ($this->cache === null) {
                $result = $this->httpClient->request('GET', self::URL);
                $body = (string) $result->getBody();
                $decoded = \json_decode($body, true);
                
                $this->updateCache((float) $decoded['data']['compra']['arsbtc']);
            }
                        
            return $arsAmount / $this->cache;
        } catch (TransferException $e) {
            throw new ServiceRuntimeException('Error requesting Bitcoin conversion: ' . $e->getMessage());
        }
    }
    
    private function updateCache(float $btc)
    {
        $this->cache = $btc;
    }
}
