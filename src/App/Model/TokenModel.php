<?php

declare(strict_types=1);

namespace App\Model;

class TokenModel
{
    private string $token;
    
    private string $refreshToken;
    
    private int $expires;
    
    private string $username;
    
    public function __construct(string $token, string $refreshToken, int $expires, string $username)
    {
        $this->token = $token;
        $this->refreshToken = $refreshToken;
        $this->expires = $expires;
        $this->username = $username;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getExpires(): int
    {
        return $this->expires;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
