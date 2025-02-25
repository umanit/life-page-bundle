<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Umanit\LifePageBundle\Event\UnavailableServicesEvent;

class ResponseBuilder implements ResponseBuilderInterface
{
    /** @var ServiceCheckerCollectionInterface */
    private $checkersCollection;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(
        ServiceCheckerCollectionInterface $checkersCollection,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->checkersCollection = $checkersCollection;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function buildResponse(string $type): Response
    {
        $response = '';
        $allOk = 1;
        $unavailableServices = [];

        foreach ($this->checkersCollection->getCheckers($type)->checkAll() as $check) {
            $status = $check->getStatus();
            if (null === $status) {
                continue;
            }

            $response .= sprintf('%s: %s', $check->getName(), $check->getTextStatus()) . PHP_EOL;
            $allOk &= (int) $status;

            if (false === $status) {
                $unavailableServices[] = $check->getName();
            }
        }

        if (!empty($unavailableServices)) {
            $event = new UnavailableServicesEvent($unavailableServices);

            $this->eventDispatcher->dispatch($event);
        }

        return new Response(
            $response,
            $allOk ? Response::HTTP_OK : Response::HTTP_SERVICE_UNAVAILABLE,
            ['Content-Type' => 'text/plain; charset=UTF-8']
        );
    }
}
