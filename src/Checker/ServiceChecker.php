<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker;

final class ServiceChecker implements CheckerInterface
{
    /** @var CheckerInterface[] */
    private $services;

    public function __construct(iterable $services)
    {
        $this->services = $services;
    }

    public function check(): bool
    {
        foreach ($this->services as $service) {
            if (!$service->check()) {
                return false;
            }
        }

        return true;
    }
}
