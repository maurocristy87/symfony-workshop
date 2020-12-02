<?php

declare(strict_types=1);

namespace Infrastructure\Service\User;

use Domain\Entity\User;
use Domain\Service\User\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface as SymfonyPasswordEncoder;

class UserPasswordEncoder implements UserPasswordEncoderInterface
{
    private SymfonyPasswordEncoder $userPasswordEncoder;
    
    public function __construct(SymfonyPasswordEncoder $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }
    
    public function encode(User $user, string $password): string
    {
        return $this->userPasswordEncoder->encodePassword($user, $password);
    }
}
