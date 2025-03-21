<?php

declare(strict_types=1);

namespace App\QueryBus;

use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class QueryBus
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function dispatch(object $command): mixed
    {
        $envelope = $this->bus->dispatch($command);
        $handledStamp = $envelope->last(HandledStamp::class);

        if (null === $handledStamp) {
            throw new \LogicException('No handler returned a value.');
        }

        return $handledStamp->getResult();
    }
}
