<?php

namespace App\Tests\Unit\Model\User\Entity\User\SignUp;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class ConfirmTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->buildUser();

        $user->confirmSignUp();
        self::assertFalse($user->isWait());
        self::assertTrue($user->isActive());
    }

    public function testAlready(): void
    {
        $user = $this->buildUser();
        $user->confirmSignUp();
        $this->expectExceptionMessage('User is already confirmed.');
        $user->confirmSignUp();
    }

    private function buildUser(): User
    {
        return new User(
            Id::next(),
            new \DateTimeImmutable(),
            new Email('test@gmail.ru'),
            'hash',
            'token'
        );
    }
}