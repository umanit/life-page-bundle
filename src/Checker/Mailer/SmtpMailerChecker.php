<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker\Mailer;

use Symfony\Component\Mailer\Transport\Smtp\SmtpTransport;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Umanit\LifePageBundle\Checker\CheckerInterface;

final class SmtpMailerChecker implements CheckerInterface
{
    /** @var TransportInterface */
    private $transport;

    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public function getName(): string
    {
        return '[Mailer] SMTP connection';
    }

    public function check(): ?bool
    {
        if (!$this->transport instanceof SmtpTransport) {
            return null;
        }

        try {
            $this->transport->getStream()->initialize();
            // Should be only 250, but MailHog send a 220 for NOOP
            $this->transport->executeCommand("NOOP\r\n", [220, 250]);

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
