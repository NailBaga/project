<?php

namespace App\Model\User\UseCase\Role;

use App\Model\Flusher;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Role;
use App\Model\User\Entity\User\UserRepository;

class Handler
{
    private $user;
    private $flusher;
    private $role;

    public function __construct(UserRepository $user, Flusher $flush, Role $role)
    {
        $this->user = $user;
        $this->flusher = $flush;
        $this->role = $role;
    }

    public function handle(Command $command): void
    {
        $user = $this->user->get(new Id($command->id));

        $user->changeRole($command->role);

        $this->flusher->flush();
    }
}