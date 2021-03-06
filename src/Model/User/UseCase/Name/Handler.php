<?php

namespace App\Model\User\UseCase\Name;

use App\Model\Flusher;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Event\UserEdited;
use App\Model\User\Entity\User\Name;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\UserRepository;

class Handler
{
    private $users;
    private $flusher;

    public function __construct(UserRepository $users, Flusher $flusher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->get($id = new Id($command->id));

        $user->changeName(
            $name = new Name(
                $command->firstName,
                $command->lastName
            )
        );

        $this->flusher->flush($user);
    }


}
