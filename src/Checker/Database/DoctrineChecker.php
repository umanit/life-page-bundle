<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker\Database;

use Doctrine\ORM\EntityManagerInterface;
use Umanit\LifePageBundle\Checker\CheckerInterface;

final class DoctrineChecker implements CheckerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getName(): string
    {
        return '[Doctrine] Database connection';
    }

    public function check(): ?bool
    {
        try {
            $this->entityManager->getConnection()->connect();

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
