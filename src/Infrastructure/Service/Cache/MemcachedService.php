<?php

declare(strict_types=1);

namespace Infrastructure\Service\Cache;

class MemcachedService implements CacheServiceInterface
{
    use CacheServiceTrait;
    
    private \Memcached $memcached;
    
    private int $lifetime;
    
    public function __construct(string $host, int $port, int $lifetime)
    {
        $this->memcached = new \Memcached();
        $this->openConnection($host, $port);
        $this->lifetime = $lifetime;
    }
    
    private function openConnection(string $host, int $port): void
    {
        $this->memcached->addServer($host, $port);
    }
    
    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }
    
    public function set(string $key, $value, ?int $lifetime = null): void
    {
        $this->memcached->set($this->prefixKey($key), $value, $lifetime ?? $this->lifetime);
    }

    public function get(string $key)
    {
        $value = $this->memcached->get($this->prefixKey($key));
        
        return $value === false ? null : $value;
    }

    public function remove($key): void
    {
        $this->memcached->delete($this->prefixKey($key));
    }
}
