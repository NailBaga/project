<?php

namespace App\Tests\Unit\Model\User\Entity\User;


use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Role;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->createUser();

        self::assertTrue($user->getRole()->isUser());
        $user->changeRole(Role::admin());
        self::assertFalse($user->getRole()->isUser());
        self::assertTrue($user->getRole()->isAdmin());
    }

    public function testAlready(): void
    {
        $user = $this->createUser();

        $user->changeRole(Role::admin());
        $this->expectExceptionMessage('Role is already same.');
        $user->changeRole(Role::admin());
    }

    private function createUser()
    {
        return new User(
            $id = Id::next(),
            $date = new \DateTimeImmutable(),
            $email = new Email('test@gmail.com'),
            $hash = 'hash',
            $token = 'token'
        );
    }
}