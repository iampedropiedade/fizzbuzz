<?php

declare(strict_types=1);

namespace App\Tests\PhpUnit\Service;

use App\Service\FizzBuzzService;
use PHPUnit\Framework\TestCase;

class FizzBuzzServiceTest extends TestCase
{
    private FizzBuzzService $service;

    protected function setUp(): void
    {
        $this->service = new FizzBuzzService();
    }

    public function testGenerateFizzBuzz(): void
    {
        $result = $this->service->generateFizzBuzz(15, 3, 5, 'Fizz', 'Buzz');
        $expected = ['1', '2', 'Fizz', '4', 'Buzz', 'Fizz', '7', '8', 'Fizz', 'Buzz', '11', 'Fizz', '13', '14', 'FizzBuzz'];
        $this->assertEquals($expected, $result);
    }

    public function testGenerateFizzBuzzWithDifferentStrings(): void
    {
        $result = $this->service->generateFizzBuzz(10, 2, 3, 'Foo', 'Bar');
        $expected = ['1', 'Foo', 'Bar', 'Foo', '5', 'FooBar', '7', 'Foo', 'Bar', 'Foo'];
        $this->assertEquals($expected, $result);
    }

    public function testGenerateFizzBuzzWithNoMultiples(): void
    {
        $result = $this->service->generateFizzBuzz(5, 10, 20, 'Fizz', 'Fizz');
        $expected = ['1', '2', '3', '4', '5'];
        $this->assertEquals($expected, $result);
    }

    public function testGenerateFizzBuzzWithSingleMultiple(): void
    {
        $result = $this->service->generateFizzBuzz(6, 2, 10, 'Fizz', 'Buzz');
        $expected = ['1', 'Fizz', '3', 'Fizz', '5', 'Fizz'];
        $this->assertEquals($expected, $result);
    }

    public function testGenerateFizzBuzzWithAllMultiples(): void
    {
        $result = $this->service->generateFizzBuzz(5, 1, 1, 'Fizz', 'Buzz');
        $expected = ['FizzBuzz', 'FizzBuzz', 'FizzBuzz', 'FizzBuzz', 'FizzBuzz'];
        $this->assertEquals($expected, $result);
    }

    public function testGenerateEmpty(): void
    {
        $result = $this->service->generateFizzBuzz(0, 10, 20, 'Fizz', 'Fizz');
        $expected = [];
        $this->assertEquals($expected, $result);
    }

    public function testGenerateInvalidNumbers(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->service->generateFizzBuzz(100, 0, 0, 'Fizz', 'Fizz');
    }
}
