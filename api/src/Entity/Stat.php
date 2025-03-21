<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\IdInterface;
use App\Repository\StatRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[
    ORM\Entity(repositoryClass: StatRepository::class),
    ORM\Index(name: 'idx_stat_number_limit', columns: ['number_limit']),
    ORM\Index(name: 'idx_stat_number1', columns: ['number1']),
    ORM\Index(name: 'idx_stat_number2', columns: ['number2']),
    ORM\Index(name: 'idx_stat_string1', columns: ['string1']),
    ORM\Index(name: 'idx_stat_string2', columns: ['string2']),
    ORM\Index(name: 'idx_stat_count', columns: ['count']),
]
class Stat implements \Stringable, IdInterface
{
    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column(type: 'integer', nullable: false),
        OA\Property(example: 1),
    ]
    private ?int $id = null;

    #[
        ORM\Column(nullable: false),
        Assert\NotBlank,
        Assert\NotNull,
        Assert\GreaterThanOrEqual(value: 1),
        OA\Property(example: 100),
    ]
    private int $count = 0;

    #[
        ORM\Column(nullable: false),
        Assert\NotBlank,
        Assert\NotNull,
        Assert\GreaterThanOrEqual(value: 1),
        OA\Property(example: 100),
    ]
    private int $numberLimit;

    #[
        ORM\Column(nullable: false),
        Assert\NotBlank,
        Assert\NotNull,
        Assert\GreaterThanOrEqual(value: 1),
        OA\Property(example: 3),
    ]
    private int $number1;

    #[
        ORM\Column(nullable: false),
        Assert\NotBlank,
        Assert\NotNull,
        Assert\GreaterThanOrEqual(value: 1),
        OA\Property(example: 5),
    ]
    private int $number2;

    #[
        ORM\Column(type: 'string', length: 200, nullable: false),
        Assert\NotBlank,
        Assert\NotNull,
        Assert\Length(min: 1),
        OA\Property(example: 'Fizz'),
    ]
    private string $string1;

    #[
        ORM\Column(type: 'string', length: 200, nullable: false),
        Assert\NotBlank,
        Assert\NotNull,
        Assert\Length(min: 1),
        OA\Property(example: 'Buzz'),
    ]
    private string $string2;

    public function __construct(
        int $numberLimit,
        int $number1,
        int $number2,
        string $string1,
        string $string2,
    ) {
        $this->numberLimit = $numberLimit;
        $this->number1 = $number1;
        $this->number2 = $number2;
        $this->string1 = $string1;
        $this->string2 = $string2;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id = null): self
    {
        $this->id = $id;

        return $this;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): Stat
    {
        $this->count = $count;

        return $this;
    }

    public function incrementCount(): Stat
    {
        ++$this->count;

        return $this;
    }

    public function getNumberLimit(): int
    {
        return $this->numberLimit;
    }

    public function setNumberLimit(int $numberLimit): Stat
    {
        $this->numberLimit = $numberLimit;

        return $this;
    }

    public function getNumber1(): int
    {
        return $this->number1;
    }

    public function setNumber1(int $number1): Stat
    {
        $this->number1 = $number1;

        return $this;
    }

    public function getNumber2(): int
    {
        return $this->number2;
    }

    public function setNumber2(int $number2): Stat
    {
        $this->number2 = $number2;

        return $this;
    }

    public function getString1(): string
    {
        return $this->string1;
    }

    public function setString1(string $string1): Stat
    {
        $this->string1 = $string1;

        return $this;
    }

    public function getString2(): string
    {
        return $this->string2;
    }

    public function setString2(string $string2): Stat
    {
        $this->string2 = $string2;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf(
            'Limit: %s, Number1: %s, Number2: %s, String1: %s, String2: %s, Count: %s',
            $this->numberLimit,
            $this->number1,
            $this->number2,
            $this->string1,
            $this->string2,
            $this->count
        );
    }
}
