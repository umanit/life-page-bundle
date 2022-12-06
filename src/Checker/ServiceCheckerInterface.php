<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker;

use Umanit\LifePageBundle\DTO\CheckInterface;

interface ServiceCheckerInterface
{
    /**
     * @return CheckInterface[]
     */
    public function checkAll(): array;
}
