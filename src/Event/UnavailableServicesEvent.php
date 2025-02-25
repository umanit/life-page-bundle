<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

class UnavailableServicesEvent extends Event
{
    /** @var array $services */
    private $services;

    public function __construct(array $services)
    {
        $this->services = $services;
    }

    public function getServices(): array
    {
        return $this->services;
    }
}
