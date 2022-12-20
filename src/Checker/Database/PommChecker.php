<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker\Database;

use PommProject\Foundation\Pomm;
use PommProject\Foundation\Session\Session;
use Umanit\LifePageBundle\Checker\CheckerInterface;

final class PommChecker implements CheckerInterface
{
    /** @var Session */
    private $pommSession;

    public function __construct(Pomm $pomm)
    {
        $this->pommSession = $pomm->getDefaultSession();
    }

    public function getName(): string
    {
        return '[Pomm] Database connection';
    }

    public function check(): ?bool
    {
        try {
            $this->pommSession->getConnection()->getClientEncoding();

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
