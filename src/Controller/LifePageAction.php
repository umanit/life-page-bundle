<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Umanit\LifePageBundle\Checker\ResponseBuilderInterface;

/**
 * @Route("/", name="umanit_life_page")
 */
class LifePageAction
{
    public const ROUTE_NAME = 'umanit_life_page';

    /** @var ResponseBuilderInterface */
    private $responseBuilder;

    public function __construct(ResponseBuilderInterface $responseBuilder)
    {
        $this->responseBuilder = $responseBuilder;
    }

    public function __invoke(): Response
    {
        return $this->responseBuilder->buildResponse();
    }
}
