<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class TestEvent extends Event
{
    private $message;

    public function __construct(string $message)
    {
        if (empty($message)) {
            throw new \InvalidArgumentException('Message cannot be empty.');
        }
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}