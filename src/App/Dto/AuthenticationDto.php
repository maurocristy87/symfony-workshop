<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class AuthenticationDto
{
    /**
     * @Assert\Email
     * @Assert\NotBlank
     */
    private string $username;
    
    /**
     * @Assert\NotBlank
     */
    private string $password;
    
    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        
        return $this;
    }
}
