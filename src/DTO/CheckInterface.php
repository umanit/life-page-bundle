<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\DTO;

interface CheckInterface
{
    public function getName(): string;

    public function getStatus(): ?string;
}
