<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Stat;

readonly class StatsResultDto
{
    public int $count;
    public int $numberLimit;
    public int $number1;
    public int $number2;
    public string $string1;
    public string $string2;

    public function __construct(
        Stat $stat,
    ) {
        $this->count = $stat->getCount();
        $this->numberLimit = $stat->getNumberLimit();
        $this->number1 = $stat->getNumber1();
        $this->number2 = $stat->getNumber2();
        $this->string1 = $stat->getString1();
        $this->string2 = $stat->getString2();
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getNumberLimit(): int
    {
        return $this->numberLimit;
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
