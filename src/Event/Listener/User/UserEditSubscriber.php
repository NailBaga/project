<?php

namespace App\Event\Listener\User;


use App\Model\Blog\Entity\Author\Author;
use App\Model\Blog\Entity\Author\AuthorRepository;
use App\Model\Blog\Entity\Author\Id;
use App\Model\Blog\Entity\Author\Name;
use App\Model\Flusher;
use App\Model\User\Entity\User\Event\UserEdited;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserEditSubscriber implements EventSubscriberInterface
{
    private $flusher;
    private $repository;
    private $logger;

    public function __construct(AuthorRepository $repository, Flusher $flusher, LoggerInterface $logger)
    {
        $this->repository = $repository;
        $this->flusher = $flusher;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserEdited::class => [
                ['onAuthorEditExecutor']
            ],
        ];
    }

    public function onAuthorEditExecutor(UserEdited $event)
    {
        $author = $this->repository->get(new Id($event->userId));
        $author->edit(
            new Name($event->firstName, $event->lastName)
        );
        $this->flusher->flush();
    }
}