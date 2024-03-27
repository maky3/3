<?php

namespace App\EventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use Psr\Log\LoggerInterface;

class LoggingEventDispatcher implements EventDispatcherInterface
{
    private EventDispatcherInterface $dispatcher;
    private LoggerInterface $logger;

    public function __construct(EventDispatcherInterface $dispatcher, LoggerInterface $logger)
    {
        $this->dispatcher = $dispatcher;
        $this->logger = $logger;
    }

    public function dispatch(object $event): object
    {
        $eventName = get_class($event);

        $this->logger->info(sprintf('Dispatching event "%s"', $eventName));

        $result = $this->dispatcher->dispatch($event);

        if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
            $this->logger->info(sprintf('Event "%s" was stopped', $eventName));
        } else {
            $this->logger->info(sprintf('Event "%s" was dispatched', $eventName));
        }

        return $result;
    }
}