<?php

namespace App\Model;


use Symfony\Component\EventDispatcher\EventDispatcherInterface;

interface EventDispatcher
{
    public function dispatch(array $events): void;
}