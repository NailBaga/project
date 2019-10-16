<?php

namespace App\Model\Blog\UseCase\Post\Edit;

use App\Model\Blog\Entity\Post\Post;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    public $id;

    public $title;

    public $content;

    public static function fromPost(Post $post): self
    {
        $command = new self();
        $command->id = $post->getId()->getValue();
        $command->title = $post->getTitle();
        $command->content = $post->getContent()->getContent();

        return $command;
    }
}