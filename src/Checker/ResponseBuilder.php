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

        foreach ($this->checker->checkAll() as $check) {
            $response .= sprintf('%s: %s', $check->getName(), $check->getStatus()).PHP_EOL;
        }

        return new Response($response);
    }
}
