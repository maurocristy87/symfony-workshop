<?php

namespace Infrastructure\Service\Cache;

trait CacheServiceTrait
{
    private function prefixKey(string $key): string
    {
        return sprintf('%s%s', CacheServiceInterface::PREFIX, $key);
    }
}
