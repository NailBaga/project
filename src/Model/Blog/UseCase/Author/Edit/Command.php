<?php

namespace App\Model\Blog\UseCase\Author\Edit;

use App\Model\Blog\Entity\Author\Author;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $firstName;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $lastName;


    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromAuthor(Author $author)
    {
        $command = new self($author->getId()->getValue());
        $command->firstName = $author->getName()->getFirst();
        $command->lastName = $author->getName()->getLast();

        return $command;
    }
}

