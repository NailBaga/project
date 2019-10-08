<?php

namespace App\Tests\Unit\Model\Blog\Entity\Post;

use App\Model\Blog\Entity\Author\Author;
use App\Model\Blog\Entity\Author\Id;
use App\Model\Blog\Entity\Author\Name;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{
    public function testSuccess(): void
    {
        $author = new Author(
            $id = Id::next(),
            $name = new Name(
                'first',
                'last'
            )
        );

        $this->assertEquals($id, $author->getId());
        $this->assertEquals($name, $author->getName());
        $this->assertTrue($author->isActive());
    }
}