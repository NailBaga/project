<?php

namespace App\Model\Blog\Entity\Author;


class Author
{
    private $id;

    private $name;

    private $status;

    public function __construct(Id $id, Name $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = Status::active();
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
}