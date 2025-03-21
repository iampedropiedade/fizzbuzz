<?php

namespace App\Tests\PhpUnit\EventListener;

use App\Event\FizzBuzzServedEvent;
use App\EventListener\LogFizzBuzzRequest;
use App\Query\FizzBuzzQuery;
use App\Repository\StatRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LogFizzBuzzRequestTest extends TestCase
{
    private StatRepository&MockObject $repository;
    private LogFizzBuzzRequest $listener;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(StatRepository::class);
        $this->listener = new LogFizzBuzzRequest($this->repository);
    }

    public function testLogNewRequest(): void
    {
        $query = new FizzBuzzQuery(15, 3, 5, 'Fizz', 'Buzz');
        $event = new FizzBuzzServedEvent($query);
        $this->repository
            ->expects($this->once())
            ->method('incrementStat')
            ->with($query);

        $this->listener->__invoke($event);
    }
}
