<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker;

final class ServiceCheckerCollection implements ServiceCheckerCollectionInterface
{
    /** @var ServiceCheckerInterface[] */
    private $checkers;

    /**
     * @param iterable<ServiceCheckerInterface> $checkers
     */
    public function __construct(iterable $checkers)
    {
        $checkers = $checkers instanceof \Traversable ? iterator_to_array($checkers) : $checkers;

        $this->checkers = $checkers;
    }

    public function getCheckers(string $key): ServiceCheckerInterface
    {
        if (!array_key_exists($key, $this->checkers)) {
            throw new \InvalidArgumentException(sprintf('Invalid checker key "%s"', $key));
        }

        return $this->checkers[$key];
    }
}
