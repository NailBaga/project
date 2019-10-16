<?php

namespace App\Model\Blog\UseCase\Author\Edit;


use App\Model\Blog\Entity\Author\Author;
use App\Model\Blog\Entity\Author\AuthorRepository;
use App\Model\Blog\Entity\Author\Id;
use App\Model\Blog\Entity\Author\Name;
use App\Model\Flusher;

class Handler
{
    private $flusher;
    private $repository;

    public function __construct(AuthorRepository $repository, Flusher $flusher)
    {
        $this->repository = $repository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $this->repository->get(new Id($command->id));
        $this->edit(
            new Name(
                $command->firstName,
                $command->lastName)
        );
        $this->flusher->flush();
    }
}