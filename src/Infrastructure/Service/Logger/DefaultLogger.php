<?php

declare(strict_types=1);

namespace Infrastructure\Service\Logger;

use Psr\Log\LoggerInterface;
use Domain\Service\Logger\LoggerInterface as DomainLoggerInterface;

class DefaultLogger implements DomainLoggerInterface
{
    private LoggerInterface $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function debug(string $message): void
    {
        $this->logger->debug($message);
    }

    public function error(string $message): void
    {
        $this->logger->error($message);
    }

    public function info(string $message): void
    {
        $this->logger->info($message);
    }

    public function warning(string $message): void
    {
        $this->logger->warning($message);
    }
}
