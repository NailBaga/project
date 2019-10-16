<?php

namespace App\Model\Blog\Entity\Author;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog_author_author")
 */

class Author
{
    /**
     * @var Id
     * @ORM\Column(type="blog_author_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var Name
     * @ORM\Embedded(class="Name")
     */
    private $name;

    /**
     * @var Status
     * @ORM\Column(type="blog_author_status", length=16)
     */
    private $status;

    public function __construct(Id $id, Name $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = Status::active();
    }

    public function edit(Name $name): void
    {
        $this->name = $name;
    }

    public function archive(): void
    {
        if ($this->status->isArchived()) {
            throw new \DomainException('Author is already archived');
        }
        $this->status = Status::archived();
    }

    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    public function isArchived(): bool
    {
        return $this->status->isArchived();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function __toString() : string
    {
        return $this->getId();
    }
}