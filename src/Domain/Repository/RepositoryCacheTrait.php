<?php

namespace Domain\Repository;

trait RepositoryCacheTrait
{
    private function getCacheName(string $methodName): string
    {
        return sprintf('%s:%s', __CLASS__, $methodName);
    }
    
    private function clearCache(string $methodName): void
    {
        $this->getEntityManager()
            ->getConfiguration()
            ->getResultCacheImpl()
            ->delete($this->getCacheName($methodName))
        ;
    }
}
