<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Umanit\LifePageBundle\Checker\ResponseBuilderInterface;
use Umanit\LifePageBundle\Controller\LifePageAction;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /** @var ResponseBuilderInterface */
    private $responseBuilder;

    public function __construct(ResponseBuilderInterface $responseBuilder)
    {
        $this->responseBuilder = $responseBuilder;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        if (LifePageAction::ROUTE_NAME !== $event->getRequest()->attributes->get('_route')) {
            return;
        }

        try {
            $event->setResponse(
                $this->responseBuilder->buildResponse(
                    $event->getRequest()->attributes->getAlnum('type', 'all')
                )
            );
        } catch (\Throwable $e) {
            // Error on life page rendering, let the application do the job.
        }
    }
}
