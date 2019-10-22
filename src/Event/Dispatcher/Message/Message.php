<?php

namespace App\Event\Dispatcher\Message;

class Message
{
    private $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function getEvent()
    {
        return $this->event;
    }
}
