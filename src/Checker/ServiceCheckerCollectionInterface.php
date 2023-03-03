<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker;

interface ServiceCheckerCollectionInterface
{
    public function getCheckers(string $key): ServiceCheckerInterface;
}
