<?php

declare(strict_types=1);

namespace Infrastructure\Service\Cache;

class RedisService implements CacheServiceInterface
{
    use CacheServiceTrait;
    
    private \Redis $redis;
    
    private int $lifetime;
    
    public function __construct(string $host, int $port, int $lifetime)
    {
        $this->redis = new \Redis();
        $this->openConnection($host, $port);
        $this->lifetime = $lifetime;
    }
    
    private function openConnection(string $host, int $port): void
    {
        $this->redis->connect($host, $port);
    }
    
    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }
    
    public function set(string $key, $value, ?int $lifetime = null): void
    {
        $this->redis->set($this->prefixKey($key), $value, $lifetime ?? $this->lifetime);
    }

    public function get(string $key)
    {
        $value = $this->redis->get($this->prefixKey($key));
        
        return $value === false ? null : $value;
    }

    public function remove($key): void
    {
        $this->redis->delete($this->prefixKey($key));
    }
}
