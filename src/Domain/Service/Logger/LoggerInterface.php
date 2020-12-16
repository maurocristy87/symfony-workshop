<?php

namespace Domain\Service\Logger;

interface LoggerInterface
{
    public function warning(string $message): void;
    
    public function error(string $message): void;

    public function info(string $message): void;

    public function debug(string $message): void;
}
