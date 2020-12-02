<?php

namespace Domain\Dto\User;

interface UserDtoInterface
{
    public function getUsername(): string;
    
    public function getPassword(): string;
    
    public function getEmail(): string;
}
