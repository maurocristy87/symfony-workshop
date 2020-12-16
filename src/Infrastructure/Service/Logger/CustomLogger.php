<?php

declare(strict_types=1);

namespace Infrastructure\Service\Logger;

use Psr\Log\LoggerInterface;
use Domain\Service\Logger\CustomLoggerInterface;

class CustomLogger implements CustomLoggerInterface
{
    private LoggerInterface $logger;
    
    public function __construct(LoggerInterface $customLogger)
    {
        $this->logger = $customLogger;
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
