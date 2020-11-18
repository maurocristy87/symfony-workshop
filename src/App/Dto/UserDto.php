<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    /**
     * @Assert\Email
     * @Assert\NotBlank
     */
    private string $username;
    
    /**
     * @Assert\Email
     * @Assert\NotBlank
     */
    private string $email;
    
    /**
     * @Assert\NotBlank
     * @Asset\Length(min=3, max=255)
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
    
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        
        return $this;
    }
}
