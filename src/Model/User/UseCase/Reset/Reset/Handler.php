<?php

namespace App\Model\User\UseCase\Reset\Reset;

use App\Model\Flusher;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\Service\PasswordHasher;

class Handler
{
    private $user;
    private $flusher;
    private $hasher;

    public function __construct(UserRepository $user, Flusher $flush, PasswordHasher $hasher)
    {
        $this->user = $user;
        $this->flusher = $flush;
        $this->hasher = $hasher;
    }

    public function handle(Command $command): void
    {
        $user = $this->user->findByResetToken($command->token);
        if (!$user) {
            throw \DomainException('Incorrect Token');
        }

        $user->passwordReset(
            new \DateTimeImmutable(),
            $this->hasher->hash($command->password)
        );

        $this->flusher->flush();
    }
}