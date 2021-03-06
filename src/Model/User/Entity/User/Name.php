<?php

namespace App\Model\User\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class Name
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $first;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $last;

    public function __construct(string $first, string $last)
    {
        Assert::notEmpty($first);
        Assert::notEmpty($last);

        $this->first = $first;
        $this->last = $last;
    }

    public function getFirst(): ?string
    {
        return $this->first;
    }

    public function getLast(): ?string
    {
        return $this->last;
    }
}