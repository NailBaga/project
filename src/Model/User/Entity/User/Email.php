<?php
/**
 * Created by PhpStorm.
 * User: nail
 * Date: 18.09.19
 * Time: 13:31
 */

namespace App\Model\User\Entity\User;


use http\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;

class Email
{
   private $value;

   public function __construct(string $value)
   {
       Assert::assertNotEmpty($value);
       if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
           throw new InvalidArgumentException('Incorrect Email');
       }
       $this->value = mb_strtolower($value);
   }

    public function getValue(): string
    {
        return $this->value;
    }
}