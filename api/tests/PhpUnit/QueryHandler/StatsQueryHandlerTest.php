<?php

declare(strict_types=1);

namespace App\Tests\PhpUnit\QueryHandler;

use App\Dto\StatsResultDto;
use App\Entity\Stat;
use App\Query\StatsQuery;
use App\QueryHandler\StatsQueryHandler;
use App\Repository\StatRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class StatsQueryHandlerTest extends TestCase
{
    private StatRepository&MockObject $repository;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(StatRepository::class);
    }

    public function testHandleReturnsStatsResultDto(): void
    {
        $stat = (new Stat(15, 3, 5, 'Fizz', 'Buzz'))->setCount(50);
        $this->repository->expects($this->once())
            ->method('findTopRequest')
            ->willReturn($stat);

        $handler = new StatsQueryHandler($this->repository);
        $query = new StatsQuery();

        $result = $handler($query);

        $this->assertInstanceOf(StatsResultDto::class, $result);
        $this->assertEquals($stat->getCount(), $result->count);
        $this->assertEquals($stat->getNumberLimit(), $result->numberLimit);
        $this->assertEquals($stat->getNumber1(), $result->number1);
        $this->assertEquals($stat->getNumber2(), $result->number2);
        $this->assertEquals($stat->getString1(), $result->string1);
        $this->assertEquals($stat->getString2(), $result->string2);
    }

    public function testHandleReturnsNullWhenNoStatsFound(): void
    {
        $this->repository->expects($this->once())
            ->method('findTopRequest')
            ->willReturn(null);

        $handler = new StatsQueryHandler($this->repository);
        $query = new StatsQuery();

        $result = $handler($query);

        $this->assertNull($result);
    }
}
