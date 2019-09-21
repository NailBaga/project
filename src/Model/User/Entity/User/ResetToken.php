<?php

namespace App\Model\User\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class ResetToken
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $token;
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
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

    /**
     * @internal for postLoad callback
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->token);
    }
}