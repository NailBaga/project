<?php

namespace App\Model\Blog\UseCase\Post\Create;


use App\Model\Blog\Entity\Author\AuthorRepository;
use \App\Model\Blog\Entity\Author\Id as AuthorId;
use App\Model\Blog\Entity\Post\Content;
use App\Model\Blog\Entity\Post\Id;
use App\Model\Blog\Entity\Post\Post;
use App\Model\Blog\Entity\Post\PostRepository;
use App\Model\Flusher;

class Handler
{
    private $flusher;
    private $authorRepository;
    private $postRepository;

    public function __construct(AuthorRepository $authorRepository, PostRepository $postRepository, Flusher $flusher)
    {
        $this->authorRepository = $authorRepository;
        $this->postRepository = $postRepository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $id = new AuthorId($command->authorId);
        $author = $this->authorRepository->get($id);

        $post = new Post(
            Id::next(),
            new Content($command->content),
            $command->title,
            $author
        );

        $this->postRepository->add($post);

        $this->flusher->flush();
    }
}