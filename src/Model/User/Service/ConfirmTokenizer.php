<?php

namespace App\Model\User\Service;

use Ramsey\Uuid\Uuid;

class ConfirmTokenizer
{
    public function generate(): string
    {
        return Uiid::uiid4()->toString();
    }
}