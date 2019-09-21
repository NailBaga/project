<?php

namespace App\Tests\Unit\Model\User\Entity\User\Reset;


use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\ResetToken;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $now = new \DateTimeImmutable();
        $token = new ResetToken('token', $now->modify('+1 day'));

        $user = $this->buildSignedUpByEmailUser();
        $user->confirmSignUp();

        $user->requestPasswordReset($token, $now);

        self::assertNotNull($user->getResetToken());
    }

    public function testAlready(): void
    {
        $now = new \DateTimeImmutable();
        $token = new ResetToken('token', $now->modify('+1 day'));

        $user = $this->buildSignedUpByEmailUser();
        $user->confirmSignUp();

        $user->requestPasswordReset($token, $now);

        $this->expectExceptionMessage('Resetting is already requested.');
        $user->requestPasswordReset($token, $now);
    }

    public function testExpired(): void
    {
        $user = $this->buildSignedUpByEmailUser();
        $user->confirmSignUp();

        $now = new \DateTimeImmutable();
        $token1 = new ResetToken('token', $now->modify('+1 day'));
        $user->requestPasswordReset($token1, $now);
        self::assertEquals($token1, $user->getResetToken());

        $token2 = new ResetToken('token', $now->modify('3 day'));

        $user->requestPasswordReset($token2, $now->modify('+1 day'));
        self::assertEquals($token2, $user->getResetToken());
    }

    public function testNotConfirmed(): void
    {
        $now = new \DateTimeImmutable();
        $token = new ResetToken('token', $now->modify('+1 day'));

        $user = $this->buildSignedUpByEmailUser();

        $this->expectExceptionMessage('User is not active.');
        $user->requestPasswordReset($token, $now);
    }

    private function buildSignedUpByEmailUser(): User
    {
        $user = new User(
            $id = Id::next(),
            $date = new \DateTimeImmutable(),
            $email = new Email('test@gmail.com'),
            $hash = 'hash',
            $token = 'token'
        );

        return $user;
    }
}