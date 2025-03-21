<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Event\FizzBuzzServedEvent;
use App\Repository\StatRepository;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: FizzBuzzServedEvent::class)]
readonly class LogFizzBuzzRequest
{
    public function __construct(
        private StatRepository $statRepository,
    ) {
    }

    public function __invoke(FizzBuzzServedEvent $event): void
    {
        $query = $event->getQuery();
        $this->statRepository->incrementStat($query);
    }
}
