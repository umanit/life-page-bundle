<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker\Mailer;

use Umanit\LifePageBundle\Checker\CheckerInterface;

final class SwiftmailerChecker implements CheckerInterface
{
    /** @var \Swift_Mailer */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function getName(): string
    {
        return '[Swiftmailer] SMTP connection';
    }

    public function check(): bool
    {
        return $this->mailer->getTransport()->ping();
    }
}
