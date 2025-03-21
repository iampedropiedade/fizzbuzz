<?php

declare(strict_types=1);

namespace App\Entity\Interface;

interface IdInterface
{
    public function getId(): ?int;

    public function setId(?int $id = null): self;
}
