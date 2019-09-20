<?php

namespace App\Model\User\UseCase\Reset\Request;


use App\Model\Flusher;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\Service\ResetTokenizer;
use App\Model\User\Service\ResetTokenSender;

class Handler
{
    private $users;
    private $fluser;
    private $resetTokenizer;
    private $sender;


    public function __construct(
        UserRepository $users,
        Flusher $flusher,
        ResetTokenizer $resetTokenizer,
        ResetTokenSender $sender
    )
    {
        $this->users = $users;
        $this->flusher = $flusher;
        $this->resetTokenizer = $resetTokenizer;
        $this->sender = $sender;

    }

    public function handle(Command $command): void
    {

        $user = $this->users->getByEmail(new Email($command->email));

        $user->requestPasswordReset(
            $this->resetTokenizer->generate(),
            new \DateTimeImmutable()
        );

        $this->fluser->flush();

        $this->sender->send($user->getEmail(), $user->getResetToken());
    }
}