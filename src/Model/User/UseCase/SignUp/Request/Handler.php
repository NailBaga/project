<?php

namespace App\Model\User\UseCase\SignUp\Request;


use App\Model\Flusher;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\UseCase\PasswordHasher;

class Handler
{
    private $users;
    private $hash;
    private $fluser;

    public function __construct(UserRepository $users, PasswordHasher $hash, Flusher $flusher)
    {
        $this->users = $users;
        $this->hasher = $hash;
        $this->flusher = $flusher;
    }

    public function handle(Command $command):void
    {
        $email = new Email($command->email);

        if ($this->users->hasByEmail($email->getValue())) {
            throw new \DomainException('User already exists.');
        }

        $user = new User(
            Id::next(),
            new \DateTimeImmutable(),
            $email,
            $this->hash->hash()
        );

        $this->users->add($user);

        $this->fluser->flush();
    }
}