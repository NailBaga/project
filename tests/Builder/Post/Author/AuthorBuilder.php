<?php

namespace App\Tests\Builder\Post\Author;


use App\Model\Blog\Entity\Author\Author;
use App\Model\Blog\Entity\Author\Id;
use App\Model\Blog\Entity\Author\Name;


class AuthorBuilder
{
    private $id;
    private $name;

    public function __construct()
    {
        $this->id = Id::next();
        $this->name = new Name('First', 'Last');
    }

    public function build(): Author
    {
        return new Author(
            $this->id,
            $this->name
        );
    }
}