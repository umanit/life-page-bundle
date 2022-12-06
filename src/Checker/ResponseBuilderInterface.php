<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker;

use Symfony\Component\HttpFoundation\Response;

interface ResponseBuilderInterface
{
    public function buildResponse(): Response;
}
