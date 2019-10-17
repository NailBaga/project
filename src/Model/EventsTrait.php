<?php

namespace App\Model;

trait EventsTrait
{
    private $recordedEvents = [];

    protected function recordEvent( $event): void
    {
        $this->recordedEvents[] = $event;
    }

    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];

        return $events;
    }
}