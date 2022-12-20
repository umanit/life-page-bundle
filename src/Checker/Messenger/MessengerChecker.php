<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker\Messenger;

use Symfony\Component\Messenger\Transport\Receiver\MessageCountAwareInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;
use Umanit\LifePageBundle\Checker\CheckerInterface;

final class MessengerChecker implements CheckerInterface
{
    /** @var TransportInterface */
    private $transport;

    /** @var string|null */
    private $alias;

    public function __construct(TransportInterface $transport, ?string $alias = null)
    {
        $this->transport = $transport;
        $this->alias = $alias;
    }

    public function getName(): string
    {
        $alias = null;

        if (null !== $this->alias) {
            $alias = sprintf(' "%s"', $this->alias);
        }

        return sprintf('[Messenger] Transport%s connection', $alias);
    }

    public function check(): ?bool
    {
        if (!$this->transport instanceof MessageCountAwareInterface) {
            return null;
        }

        try {
            $this->transport->getMessageCount();

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
