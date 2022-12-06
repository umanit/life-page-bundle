<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\DTO;

final class Check implements CheckInterface
{
    /** @var string */
    private $name;

    /** @var string [OK|KO] */
    private $status;

    public function __construct(string $name, bool $checkStatus)
    {
        $this->name = $name;

        $this->applyStatus($checkStatus);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    private function applyStatus(bool $checkStatus): void
    {
        $this->status = $checkStatus ? 'OK' : 'KO';
    }
}
