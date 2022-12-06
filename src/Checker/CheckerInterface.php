<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker;

interface CheckerInterface
{
    public function getName(): string;

    public function check(): bool;
}
