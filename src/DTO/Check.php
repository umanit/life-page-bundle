<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\DTO;

final class Check implements CheckInterface
{
    private const STATUS_OK = 'OK';
    private const STATUS_KO = 'KO';

    /** @var string */
    private $name;

    /** @var bool|null */
    private $status;

    public function __construct(string $name, ?bool $status)
    {
        $this->name = $name;
        $this->status = $status;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function getTextStatus(): string
    {
        if (null === $this->status) {
            throw new \LogicException('Can not get text status if there is no status!');
        }

        return $this->status ? self::STATUS_OK : self::STATUS_KO;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
