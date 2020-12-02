<?php

namespace Domain\Service\User;

use Domain\Entity\User;

interface UserPasswordEncoderInterface
{
    public function encode(User $user, string $password): string;
}
