<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker;

use Umanit\LifePageBundle\DTO\Check;
use Umanit\LifePageBundle\DTO\CheckCollection;

final class ServiceChecker implements ServiceCheckerInterface
{
    /** @var CheckerInterface[] */
    private $services;

    public function __construct(iterable $services)
    {
        $this->services = $services;
    }

    public function checkAll(): array
    {
        $collection = new CheckCollection();

        foreach ($this->services as $service) {
            $collection->addCheck(new Check($service->getName(), $service->check()));
        }

        return $collection->getChecks();
    }
}
