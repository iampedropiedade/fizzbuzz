<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\ConstraintViolationInterface;

class ViolationDto
{
    public string $property;
    public string $violation;
    private ConstraintViolationInterface $constraintViolation;

    public function __construct(?ConstraintViolationInterface $constraintViolation = null)
    {
        if (null !== $constraintViolation) {
            $this->constraintViolation = $constraintViolation;
            $this->setViolation(strval($this->constraintViolation->getMessage()));
            $this->setPropertyPath($this->constraintViolation->getPropertyPath());
        }
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function setPropertyPath(string $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getViolation(): string
    {
        return $this->violation;
    }

    public function setViolation(string $violation): ViolationDto
    {
        $this->violation = $violation;

        return $this;
    }

    /**
     * @return string|int
     */
    public function getValue(): mixed
    {
        if (is_object($this->constraintViolation->getInvalidValue())) {
            return '[object]';
        }
        if (is_array($this->constraintViolation->getInvalidValue())) {
            return '[array]';
        }

        return $this->constraintViolation->getInvalidValue();
    }
}
