<?php

declare(strict_types=1);

namespace App\QueryHandler;

use App\Event\FizzBuzzServedEvent;
use App\Query\FizzBuzzQuery;
use App\Service\FizzBuzzService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class FizzBuzzQueryHandler
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
        private FizzBuzzService $service,
    ) {
    }

    /**
     * @return string[]
     */
    public function __invoke(FizzBuzzQuery $query): array
    {
        $this->eventDispatcher->dispatch(new FizzBuzzServedEvent($query));

        return $this->service->generateFizzBuzz($query->getLimit(), $query->getNumber1(), $query->getNumber2(), $query->getString1(), $query->getString2());
    }
}
