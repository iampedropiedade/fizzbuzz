<?php

declare(strict_types=1);

namespace App\Tests\PhpUnit\QueryHandler;

use App\Event\FizzBuzzServedEvent;
use App\Query\FizzBuzzQuery;
use App\QueryHandler\FizzBuzzQueryHandler;
use App\Service\FizzBuzzService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class FizzBuzzQueryHandlerTest extends TestCase
{
    private EventDispatcherInterface&MockObject $eventDispatcher;
    private FizzBuzzService&MockObject $service;
    private FizzBuzzQueryHandler $handler;

    protected function setUp(): void
    {
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->service = $this->createMock(FizzBuzzService::class);

        $this->handler = new FizzBuzzQueryHandler(
            $this->eventDispatcher,
            $this->service
        );
    }

    public function testInvokeDispatchesEventAndCallsService(): void
    {
        $query = new FizzBuzzQuery(15, 3, 5, 'Fizz', 'Buzz');
        $expectedResult = ['1', '2', 'Fizz', '4', 'Buzz', 'Fizz', '7', '8', 'Fizz', 'Buzz', '11', 'Fizz', '13', '14', 'FizzBuzz'];

        $this->eventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(FizzBuzzServedEvent::class));

        $this->service
            ->expects($this->once())
            ->method('generateFizzBuzz')
            ->with(15, 3, 5, 'Fizz', 'Buzz')
            ->willReturn($expectedResult);

        $result = $this->handler->__invoke($query);

        $this->assertEquals($expectedResult, $result);
    }
}
