<?php
/**
 * Created by PhpStorm.
 * User: nail
 * Date: 18.09.19
 * Time: 8:46
 */

namespace App\Model\User\Entity\User;


class User
{

    private $id;

    /**
     * @var \DateTimeImmutable
     */
    private $date;

    private $email;

    private $passwordHash;

    public function __construct(Id $id, \DateTimeImmutable $date, Email $email, string $passwordHash)
    {
        $this->id = $id;
        $this->date = $date;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    public function getId() : Id
    {
        return $this->id;
    }


    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
}