<?php

declare(strict_types=1);

namespace Tests\Domain\Service\User;

use Domain\Dto\User\UserDtoInterface;
use Domain\Entity\User;
use Domain\Exception\ServiceValidationException;
use Domain\Exception\UserDuplicatedException;
use Domain\Repository\UserRepositoryInterface;
use Domain\Service\User\CreateUserService;
use Domain\Service\User\UserPasswordEncoderInterface;
use PHPUnit\Framework\TestCase;

class CreateUserServiceTest extends TestCase
{
    public function testCreateSucess()
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->method('persist');
        
        $userPasswordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $userPasswordEncoder->method('encode')->willReturn('asdfgh123456');
        
        $dto = $this->createMock(UserDtoInterface::class);
        $dto->method('getUsername')->willReturn('arya.stark');
        $dto->method('getEmail')->willReturn('arya.stark@winterfell.com');
        $dto->method('getpassword')->willReturn('123456');
        
        $service = new CreateUserService($userRepository, $userPasswordEncoder);
        
        $user = $service->create($dto);
        
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($dto->getUsername(), $user->getUsername());
        $this->assertEquals($dto->getEmail(), $user->getEmail());
        $this->assertEquals('asdfgh123456', $user->getPassword());
        $this->assertContains(User::ROLE_USER, $user->getRoles());
    }
    
    public function testCreateThrowsException()
    {
        $this->expectException(ServiceValidationException::class);
        
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->method('persist')->willThrowException(new UserDuplicatedException());
        
        $userPasswordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $userPasswordEncoder->method('encode')->willReturn('asdfgh123456');
        
        $dto = $this->createMock(UserDtoInterface::class);
        $dto->method('getUsername')->willReturn('arya.stark');
        $dto->method('getEmail')->willReturn('arya.stark@winterfell.com');
        $dto->method('getpassword')->willReturn('123456');
        
        $service = new CreateUserService($userRepository, $userPasswordEncoder);
        
        $service->create($dto);
    }
}
