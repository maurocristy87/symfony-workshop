<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class RefreshTokenDto
{
    /**
     * @Assert\NotBlank
     */
    private string $refreshToken;
    
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function setRefreshToken(string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;
        
        return $this;
    }
}
