<?php

declare(strict_types=1);

namespace App\Query;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

readonly class FizzBuzzQuery
{
    public function __construct(
        #[
            Assert\NotBlank,
            Assert\NotNull,
            Assert\GreaterThanOrEqual(value: 1),
            OA\Property(example: 100),
        ]
        private int $limit,
        #[
            Assert\NotBlank,
            Assert\NotNull,
            Assert\GreaterThanOrEqual(value: 1),
            OA\Property(example: 3),
        ]
        private int $number1,
        #[
            Assert\NotBlank,
            Assert\NotNull,
            Assert\GreaterThanOrEqual(value: 1),
            OA\Property(example: 5),
        ]
        private int $number2,
        #[
            Assert\NotBlank,
            Assert\NotNull,
            Assert\Length(min: 1),
            OA\Property(example: 'Fizz'),
        ]
        private string $string1,
        #[
            Assert\NotBlank,
            Assert\NotNull,
            Assert\Length(min: 1),
            OA\Property(example: 'Buzz'),
        ]
        private string $string2,
    ) {
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getNumber1(): int
    {
        return $this->number1;
    }

    public function getNumber2(): int
    {
        return $this->number2;
    }

    public function getString1(): string
    {
        return $this->string1;
    }

    public function getString2(): string
    {
        return $this->string2;
    }
}
