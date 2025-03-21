<?php

declare(strict_types=1);

namespace App\Tests\PhpUnit\Controller;

use App\Controller\FizzBuzzController;
use App\Query\FizzBuzzQuery;
use App\QueryBus\QueryBus;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FizzBuzzControllerTest extends TestCase
{
    private SerializerInterface&MockObject $serializer;
    private ValidatorInterface&MockObject $validator;
    private QueryBus&MockObject $queryBus;
    private FizzBuzzController $controller;

    protected function setUp(): void
    {
        $this->queryBus = $this->createMock(QueryBus::class);
        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->controller = new FizzBuzzController(
            $this->serializer,
            $this->validator,
            $this->queryBus
        );
    }

    public function testInvokeReturnsResults(): void
    {
        $query = new FizzBuzzQuery(15, 3, 5, 'Fizz', 'Buzz');
        $expectedResult = ['1', '2', 'Fizz', '4', 'Buzz', 'Fizz', '7', '8', 'Fizz', 'Buzz', '11', 'Fizz', '13', '14', 'FizzBuzz'];

        $this->queryBus->expects($this->once())
            ->method('dispatch')
            ->with($query)
            ->willReturn($expectedResult);

        $response = $this->controller->__invoke($query);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(json_encode($expectedResult), $response->getContent());
    }

    public function testValidationFailure(): void
    {
        $query = new FizzBuzzQuery(-1, 3, 5, 'Fizz', 'Buzz');
        $violations = new ConstraintViolationList();
        $this->queryBus
            ->expects($this->once())
            ->method('dispatch')
            ->with($query)
            ->willThrowException(new ValidationFailedException($query, $violations));

        $response = $this->controller->__invoke($query);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals(json_encode($violations), $response->getContent());
    }

    public function testUnexpectedException(): void
    {
        $query = new FizzBuzzQuery(100, 3, 5, 'Fizz', 'Buzz');

        $this->queryBus
            ->expects($this->once())
            ->method('dispatch')
            ->with($query)
            ->willThrowException(new \RuntimeException('Something went wrong'));

        $response = $this->controller->__invoke($query);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals('Invalid request', json_decode($response->getContent() ?: ''));
    }
}
