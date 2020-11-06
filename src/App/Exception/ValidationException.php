<?php

declare(strict_types=1);

namespace App\Exception;

class ValidationException extends \Exception
{
    private const MESSAGE = 'Validation errors found.';
    
    /**
     * @var array
     */
    private $violations;
    
    public function __construct(array $violations, int $code = 400, \Throwable $previous = NULL)
    {
        parent::__construct(self::MESSAGE, $code, $previous);
        
        $this->violations = $violations;
    }
    
    public function getViolations(): array
    {
        return $this->violations;
    }
}
