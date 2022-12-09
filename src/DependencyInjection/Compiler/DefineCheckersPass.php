<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Umanit\LifePageBundle\Checker\Database\DoctrineChecker;
use Umanit\LifePageBundle\Checker\Database\PommChecker;
use Umanit\LifePageBundle\Checker\Mailer\SmtpMailerChecker;
use Umanit\LifePageBundle\Checker\Mailer\SwiftmailerChecker;

class DefineCheckersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $this->setDatabaseChecker($container);
        $this->setMailerChecker($container);
    }

    private function setDatabaseChecker(ContainerBuilder $container): void
    {
        if ($container->hasExtension('doctrine')) {
            $definition = new Definition(DoctrineChecker::class);
            $definition->setArgument(0, $container->getDefinition('doctrine.orm.default_entity_manager'));
            $definition->addTag('umanit_life_page.service_checker');
            $container->setDefinition('umanit_life_page.check_database.doctrine', $definition);
        }

        if ($container->hasExtension('pomm')) {
            $definition = new Definition(PommChecker::class);
            $definition->setArgument(0, $container->getDefinition('pomm'));
            $definition->addTag('umanit_life_page.service_checker');
            $container->setDefinition('umanit_life_page.check_database.pomm', $definition);
        }
    }

    private function setMailerChecker(ContainerBuilder $container): void
    {
        if ($container->hasExtension('swiftmailer')) {
            $definition = new Definition(SwiftmailerChecker::class);
            $definition->setArgument(0, $container->getDefinition('swiftmailer.mailer.default'));
            $definition->addTag('umanit_life_page.service_checker');
            $container->setDefinition('umanit_life_page.check_email.swiftmailer', $definition);
        }

        if ($container->has('mailer.mailer')) {
            $definition = new Definition(SmtpMailerChecker::class);
            $definition->setArgument(0, $container->getDefinition('mailer.default_transport'));
            $definition->addTag('umanit_life_page.service_checker');
            $container->setDefinition('umanit_life_page.check_email.smtp_mailer', $definition);
        }
    }
}
