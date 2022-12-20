<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\DTO;

interface CheckCollectionInterface
{
    /**
     * @return array<CheckInterface>
     */
    public function getChecks(): array;

    public function addCheck(CheckInterface $check): void;
}
