<?php

namespace App\Tests\Unit\Model\User\Entity\User\Reset;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\ResetToken;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class ResetTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->buildUser();

        $now = new \DateTimeImmutable();
        $token1 = new ResetToken('token', $now->modify('+1 day'));
        $user->requestPasswordReset($token1, $now);

        self::assertNotNull($user->getResetToken());
        $user->passwordReset(
            new \DateTimeImmutable(),
            'token'
        );

        self::assertNull($user->getResetToken());
    }

    public function testExpiredToken(): void
    {
        $user = $this->buildUser();

        $now = new \DateTimeImmutable();
        $token = new ResetToken('token', $now);
        $user->requestPasswordReset($token, $now);

        $this->expectExceptionMessage('Reset token is Expired');
        $user->passwordReset(
            $now->modify('+1 day'),
            'token'
        );
        self::assertNull($user->getResetToken());
    }

    public function testNotRequested(): void
    {
        $user = $this->buildUser();

        $this->expectExceptionMessage('Resetting is not requested.');
        $user->passwordReset(
            new \DateTimeImmutable(),
            'token'
        );
    }

    private function buildUser(): User
    {
        $user = new User(
            $id = Id::next(),
            $date = new \DateTimeImmutable(),
            $email = new Email('test@gmail.com'),
            $hash = 'hash',
            $token = 'token'
        );
        $user->confirmSignUp();

        return $user;
    }
}