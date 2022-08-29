<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Umanit\LifePageBundle\Checker\CheckerInterface;

class LifePageAction
{
    public function __invoke(CheckerInterface $checker): Response
    {
        if ($checker->check()) {
            return new Response('OK');
        }

        return new Response('KO');
    }
}
