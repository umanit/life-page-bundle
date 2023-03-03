<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Umanit\LifePageBundle\Checker\ResponseBuilderInterface;

class LifePageAction
{
    public const ROUTE_NAME = 'umanit_life_page';

    /** @var ResponseBuilderInterface */
    private $responseBuilder;

    public function __construct(ResponseBuilderInterface $responseBuilder)
    {
        $this->responseBuilder = $responseBuilder;
    }

    public function __invoke(string $type, Request $request): Response
    {
        return $this->responseBuilder->buildResponse($type);
    }
}
