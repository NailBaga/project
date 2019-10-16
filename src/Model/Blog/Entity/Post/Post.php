<?php

namespace App\Model\Blog\Entity\Post;

use App\Model\Blog\Entity\Author\Author;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog_post")
 */

class Post
{
    /**
     * @var Id
     * @ORM\Column(type="blog_post_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=50)
     */
    private $title;

    /**
     * @var Content
     * @ORM\Embedded(class="Content")
     */
    private $content;
    /**
     * @var Status
     * @ORM\Column(type="blog_post_status", length=16)
     */
    private $status;

    /**
     * @var Author
     * @ORM\Column(type="blog_author_id")
     */
    private $author;

    public function __construct(Id $id, Content $content, string  $title, Author $author)
    {
        $this->id = $id;
        $this->content = $content;
        $this->status = Status::active();
        $this->title = $title;
        $this->author = $author;
    }

    public function edit(Content $content, string $title): void
    {
        $this->content = $content;
        $this->title = $title;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getAuthors()
    {
        return $this->author->toArray();
    }

    public function addAuthor(Author $author): void
    {
        $this->authors = $author;
    }


}