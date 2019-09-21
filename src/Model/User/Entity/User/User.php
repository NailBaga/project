<?php

namespace App\Model\User\Entity\User;


class User
{

    private const STATUS_WAIT = 'wait';
    private const STATUS_ACTIVE = 'active';

    private $id;

    /**
     * @var \DateTimeImmutable
     */
    private $date;

    private $email;

    private $passwordHash;

    private $status;

    /**
     * @var ResetToken|null
     */
    private $resetToken;

    private $confirmToken;

    public function __construct(Id $id, \DateTimeImmutable $date, Email $email, string $passwordHash, string $token)
    {
        $this->id = $id;
        $this->date = $date;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->confirmToken = $token;
        $this->status = self::STATUS_WAIT;
    }

    public function confirmSignUp(): void
    {
        if (!$this->isWait()) {
            throw new \DomainException('User is already confirmed.');
        }
        $this->status = self::STATUS_ACTIVE;
        $this->confirmToken = null;
    }

    public function requestPasswordReset(ResetToken $token, \DateTimeImmutable $date): void
    {
        if (!$this->email) {
            throw \DomainException('Email is not specified.');
        }

        if ($this->resetToken && !$this->resetToken->isExpired($date)) {
            throw new \DomainException('Resetting is already requested.');
        }

        $this->resetToken = $token;
    }
    public function passwordReset(\DateTimeImmutable $date, string $hash): void
    {
        if (!$this->resetToken) {
            throw new \DomainException('Resetting is not requested.');
        }

        if ($this->resetToken->isExpired($date)) {
            throw new \DomainException('Reset token is Expired');
        }
        $this->passwordHash = $hash;
        $this->resetToken = null;
    }

    public function getId() : Id
    {
        return $this->id;
    }

    public function isWait(): bool
    {
        return $this->status == self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getResetToken(): ?ResetToken
    {
        return $this->resetToken;
    }

    public function getConfirmToken(): string
    {
        return $this->confirmToken;
    }
}