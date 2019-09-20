<?php

namespace App\Model\User\Entity\User;

use Webmozart\Assert\Assert;

class ResetToken
{
    private $token;
    private $dateExpires;

    public function __construct($token, \DateTimeImmutable $dateExpires)
    {
        Assert::notEmpty($token);
        $this->token = $token;
        $this->dateExpires = $dateExpires;
    }

    public function isExpired(\DateTimeImmutable $date):bool
    {
      return $this->dateExpires <= $date;
    }
    
    public function getToken(): string
    {
        return $this->token;
    }
}