<?php

namespace App\Model\Blog\UseCase\Author\Create;


use App\Model\Blog\Entity\Author\Author;
use App\Model\Blog\Entity\Author\AuthorRepository;
use App\Model\Blog\Entity\Author\Id;
use App\Model\Blog\Entity\Author\Name;
use App\Model\Flusher;
use Zend\EventManager\Exception\DomainException;

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
        if($this->repository->find(new Id($command->id))) {
            throw new DomainException('This author is add');
        }

        $id = new Id($command->id);

        $author = new Author(
            $id,
            new Name(
                $command->firstName,
                $command->lastName
            )
        );
        $this->repository->add($author);

        $this->flusher->flush();
    }
}