<?php

declare(strict_types=1);

namespace App\Event;

use App\Query\FizzBuzzQuery;

readonly class FizzBuzzServedEvent
{
    public function __construct(private FizzBuzzQuery $query)
    {
    }

    public function getQuery(): FizzBuzzQuery
    {
        return $this->query;
    }
}
