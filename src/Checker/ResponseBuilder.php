<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker;

use Symfony\Component\HttpFoundation\Response;

class ResponseBuilder implements ResponseBuilderInterface
{
    /** @var ServiceCheckerInterface */
    private $checker;

    public function __construct(ServiceCheckerInterface $checker)
    {
        $this->checker = $checker;
    }

    public function buildResponse(): Response
    {
        $response = '';
        $allOk = 1;

        foreach ($this->checker->checkAll() as $check) {
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
