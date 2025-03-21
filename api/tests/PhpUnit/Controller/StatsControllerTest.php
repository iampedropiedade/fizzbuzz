<?php

declare(strict_types=1);

namespace App\Tests\PhpUnit\Controller;

use App\Controller\StatsController;
use App\Dto\StatsResultDto;
use App\Entity\Stat;
use App\Query\StatsQuery;
use App\QueryBus\QueryBus;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class StatsControllerTest extends TestCase
{
    private SerializerInterface&MockObject $serializer;
    private QueryBus&MockObject $queryBus;

    protected function setUp(): void
    {
        $this->queryBus = $this->createMock(QueryBus::class);
        $this->serializer = $this->createMock(SerializerInterface::class);
    }

    public function testInvokeReturnsResults(): void
    {
        $stat = (new Stat(15, 3, 5, 'Fizz', 'Buzz'))->setCount(50);
        $expectedData = new StatsResultDto($stat);
        $expectedJson = json_encode($expectedData);

        $this->queryBus->expects($this->once())
            ->method('dispatch')
            ->with(new StatsQuery())
            ->willReturn($expectedData);

        $this->serializer->expects($this->once())
            ->method('serialize')
            ->with($expectedData, 'json')
            ->willReturn($expectedJson);

        $controller = new StatsController(
            $this->serializer,
            $this->queryBus
        );

        $response = $controller->__invoke();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($expectedJson, $response->getContent());
    }

    public function testStatsControllerHandlesException(): void
    {
        $this->queryBus
            ->method('dispatch')
            ->willThrowException(new \RuntimeException('Error occurred'));

        $controller = new StatsController($this->serializer, $this->queryBus);
        $response = $controller->__invoke();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals('Error occurred', json_decode($response->getContent() ?: ''));
    }
}
