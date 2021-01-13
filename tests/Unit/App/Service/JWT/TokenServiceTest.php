<?php

declare(strict_types=1);

namespace Tests\Unit\App\Service\JWT;

use Firebase\JWT\JWT;
use App\Service\JWT\TokenService;
use PHPUnit\Framework\TestCase;

class TokenServiceTest extends TestCase
{
    public function testGenerateToken()
    {
        $secret = '123456';
        $service = new TokenService($secret);
        
        $payload = ['user' => 'sarasa'];
        $token = $service->generateToken($payload, 3600);
        
        $this->assertTrue(is_string($token));
        $this->assertEquals(JWT::encode(array_merge($payload, ['exp' => 3600]), $secret, 'HS256'), $token);
    }
}
