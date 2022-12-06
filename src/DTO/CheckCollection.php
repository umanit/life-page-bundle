<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\DTO;

final class CheckCollection implements CheckCollectionInterface
{
    /** @var CheckInterface[] */
    private $checks;

    public function __construct()
    {
        $this->checks = [];
    }

    public function getChecks(): array
    {
        return $this->checks;
    }

    public function addCheck(CheckInterface $check): void
    {
        $this->checks[] = $check;
    }
}
