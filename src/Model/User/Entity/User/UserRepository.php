<?php

namespace App\Model\User\Entity\User;


class UserRepository
{
    public function findByConfirmToken(string $token): ?User
    {

    }

    public function getByEmail(Email $email): User
    {

    }

    public function hasByEmail(Email $email): bool
    {

    }

    public function add(User $user):void
    {

    }
}