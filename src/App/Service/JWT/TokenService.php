<?php
declare(strict_types=1);

namespace App\Service\JWT;

use App\Exception\ServiceValidationException;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class TokenService
{
    private const ALGORITHM = 'HS256';
    
    private string $secret;
    
    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function generateToken(array $payload, ?int $expires = null): string
    {
        if ($expires !== null) {
            $payload['exp'] = $expires;
        }
        
        return JWT::encode($payload, $this->secret, self::ALGORITHM);
    }
    
    public function decodeToken(string $token): array
    {
        try {
            $decoded = JWT::decode($token, $this->secret, [self::ALGORITHM]);
            
            return (array) $decoded;
        } catch (ExpiredException $e) {
            throw new ServiceValidationException('Token is expired');
        } catch (\Exception $e) {
            throw new ServiceValidationException('Invalid token');
        }
    }
}
