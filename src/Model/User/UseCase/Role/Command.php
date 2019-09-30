<?php

namespace App\Model\User\UseCase\Role;

use App\Model\User\Entity\User\Role;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var Role
     */
    public $role;
}