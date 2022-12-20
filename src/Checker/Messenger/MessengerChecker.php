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

    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public function getName(): string
    {
        return '[Messenger] Transport connection';
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
