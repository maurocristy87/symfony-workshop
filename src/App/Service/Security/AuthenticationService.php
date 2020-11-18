<?php
declare(strict_types=1);

namespace App\Service\Security;

use App\Dto\AuthenticationDto;
use App\Dto\RefreshTokenDto;
use App\Exception\ServiceValidationException;
use App\Model\TokenModel;
use App\Service\JWT\TokenService;
use Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AuthenticationService
{
    private UserRepositoryInterface $userRepository;
    
    private TokenService $tokenService;
    
    private UserPasswordEncoderInterface $passwordEncoder;
    
    private int $tokenLifetime;
    
    public function __construct(
        UserRepositoryInterface $userRepository,
        TokenService $tokenService,
        UserPasswordEncoderInterface $passwordEncoder,
        int $tokenLifetime
    ) {
        $this->userRepository = $userRepository;
        $this->tokenService = $tokenService;
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenLifetime = $tokenLifetime;
    }

    public function createToken(AuthenticationDto $dto): TokenModel
    {
        $user = $this->userRepository->findOneBy(['username' => $dto->getUsername()]);
        
        if ($user === null) {
            throw new ServiceValidationException('Invalid username');
        }
        
        if ($this->passwordEncoder->isPasswordValid($user, $dto->getPassword()) === false) {
            throw new ServiceValidationException('Invalid password');
        }
        
        return $this->generateToken($user);
    }
    
    public function refreshToken(RefreshTokenDto $dto): TokenModel
    {
        $payload = $this->tokenService->decodeToken($dto->getRefreshToken());
        
        $user = $this->userRepository->find($payload['user']);
        if ($user === null) {
            throw new ServiceValidationException('Invalid token');
        }
        
        return $this->generateToken($user);
    }
    
    private function generateToken(UserInterface $user): TokenModel
    {
        $expires = time() + $this->tokenLifetime;
        $payload = ['user' => $user->getId()];
        
        return new TokenModel(
            $this->tokenService->generateToken($payload, $expires), //token
            $this->tokenService->generateToken($payload), // refresh token
            $expires,
            $user->getUsername()
        );
    }
    
    public function authenticate(string $token): UserInterface
    {
        $payload = $this->tokenService->decodeToken($token);
        
        $user = $this->userRepository->find($payload['user']);
        
        if ($user === null) {
            throw new ServiceValidationException('Invalid token');
        }
        
        return $user;
    }
}
