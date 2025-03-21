<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationDto
{
    /** @var array<ViolationDto> */
    public array $violations = [];
    public string $error = 'Validation failed';

    public function __construct(?ConstraintViolationListInterface $violations = null)
    {
        if (null !== $violations) {
            foreach ($violations as $constraintViolation) {
                $this->addViolation($constraintViolation);
            }
        }
    }

    public function setError(string $error): self
    {
        $this->error = $error;

        return $this;
    }

    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @return array<ViolationDto>
     */
    public function getViolations(): array
    {
        return $this->violations;
    }

    public function addViolation(ConstraintViolationInterface $constraintViolation): self
    {
        $this->violations[] = new ViolationDto($constraintViolation);

        return $this;
    }
}
