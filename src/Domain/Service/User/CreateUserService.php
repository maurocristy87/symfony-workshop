<?php

declare(strict_types=1);

namespace Domain\Service\User;

use Domain\Dto\User\UserDtoInterface;
use Domain\Entity\User;
use Domain\Exception\ServiceValidationException;
use Domain\Exception\UserDuplicatedException;
use Domain\Repository\UserRepositoryInterface;

interface CreateUserServiceInterface {
    public function create(UserDtoInterface $dto): User;
}

class CreateUserService implements CreateUserServiceInterface
{
    private UserRepositoryInterface $userRepository;
    
    private UserPasswordEncoderInterface $userPasswordEncoder;
    
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserPasswordEncoderInterface $userPasswordEncoder
    ) {
        $this->userRepository = $userRepository;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    
    public function create(UserDtoInterface $dto): User
    {
        $user = (new User())
            ->setUsername($dto->getUsername())
            ->setEmail($dto->getEmail())
            ->setRoles([User::ROLE_USER])
        ;
        
        $user->setPassword($this->userPasswordEncoder->encode($user, $dto->getPassword()));
        
        try {
            $this->userRepository->persist($user);
        } catch (UserDuplicatedException $ex) {
            throw new ServiceValidationException(sprintf('User with username %s already exists', $dto->getUsername()));
        }
        
        return $user;
    }
}
