<?php

namespace App\Model\User\UseCase\SignUp\Confirm;

use App\Model\Flusher;
use App\Model\User\Entity\User\UserRepository;

class Handler
{
    private $userRepository;
    private $flusher;


    public function __construct(UserRepository $userRepository,  Flusher $flusher)
    {
        $this->userRepository = $userRepository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command)
    {
        $user = $this->userRepository->findByConfirmToken($command->token);

        if (empty($user)) {
            throw \DomainException('Incorrect token');
        }

        $user->confirmSignUp();

        $this->flusher->flush();
    }
}