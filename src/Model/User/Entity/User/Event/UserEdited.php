<?php

namespace App\Model\User\Entity\User\Event;

use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Name;

class UserEdited
{
    public $userId;
    public $firstName;
    public $lastName;

    public function __construct(string $userId, string $firsName, string $lastName)
    {
        $this->userId = $userId;
        $this->firstName = $firsName;
        $this->lastName = $lastName;
    }
}