<?php

namespace App\Model\Blog\UseCase\Post\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $authorId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $content;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $title;

    public function __construct($authorId)
    {
        $this->authorId = $authorId;
    }
}