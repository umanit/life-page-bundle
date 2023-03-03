<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker;

use Symfony\Component\HttpFoundation\Response;

class ResponseBuilder implements ResponseBuilderInterface
{
    /** @var ServiceCheckerCollectionInterface */
    private $checkersCollection;

    public function __construct(ServiceCheckerCollectionInterface $checkersCollection)
    {
        $this->checkersCollection = $checkersCollection;
    }

    public function buildResponse(string $type): Response
    {
        $response = '';
        $allOk = 1;

        foreach ($this->checkersCollection->getCheckers($type)->checkAll() as $check) {
            $status = $check->getStatus();
            if (null === $status) {
                continue;
            }

            $response .= sprintf('%s: %s', $check->getName(), $check->getTextStatus()).PHP_EOL;
            $allOk &= (int) $status;
        }

        return new Response(
            $response,
            $allOk ? Response::HTTP_OK : Response::HTTP_SERVICE_UNAVAILABLE,
            ['Content-Type' => 'text/plain; charset=UTF-8']
        );
    }
}
