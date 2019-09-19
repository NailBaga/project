<?php
/**
 * Created by PhpStorm.
 * User: nail
 * Date: 18.09.19
 * Time: 8:46
 */

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

    public function getConfirmToken(): string
    {
        return $this->confirmToken;
    }
}