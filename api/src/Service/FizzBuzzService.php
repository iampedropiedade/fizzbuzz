<?php

declare(strict_types=1);

namespace App\Service;

readonly class FizzBuzzService
{
    /**
     * @return string[]
     */
    public function generateFizzBuzz(int $limit, int $number1, int $number2, string $string1, string $string2): array
    {
        if ($number1 <= 0 || $number2 <= 0) {
            throw new \InvalidArgumentException('Numbers must be greater than 0');
        }
        $results = [];
        for ($index = 1; $index <= $limit; ++$index) {
            $result = '';
            if (0 === $index % $number1) {
                $result .= $string1;
            }
            if (0 === $index % $number2) {
                $result .= $string2;
            }
            $results[] = '' !== $result ? $result : (string) $index;
        }

        return $results;
    }
}
