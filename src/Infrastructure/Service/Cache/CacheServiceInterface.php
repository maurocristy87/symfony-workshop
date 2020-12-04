<?php

namespace Infrastructure\Service\Cache;

interface CacheServiceInterface
{
    const PREFIX = 'workshop:';
    
    public function has(string $key): bool;
    public function get(string $key);
    public function set(string $key, $value, ?int $lifetime = nul1): void;
    public function remove($key): void;
}
