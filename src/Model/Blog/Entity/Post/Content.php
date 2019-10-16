<?php

namespace App\Model\Blog\Entity\Post;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class Content
{
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $content;

    public function __construct(string $content)
    {
        Assert::notEmpty($content);

        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }

}