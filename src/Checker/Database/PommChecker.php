<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker\Database;

use PommProject\Foundation\Pomm;
use Umanit\LifePageBundle\Checker\CheckerInterface;

final class PommChecker implements CheckerInterface
{
    /** @var Pomm */
    private $pomm;

    public function __construct(Pomm $pomm)
    {
        $this->pomm = $pomm;
    }

    public function getName(): string
    {
        return '[Pomm] Database connection';
    }

    public function check(): bool
    {
        try {
            $this->pomm->getDefaultSession()->getConnection()->getClientEncoding();

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
