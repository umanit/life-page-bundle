<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Umanit\LifePageBundle\Checker\Database\DoctrineChecker;
use Umanit\LifePageBundle\Checker\Database\PommChecker;
use Umanit\LifePageBundle\Checker\Elasticsearch\FosElasticaChecker;
use Umanit\LifePageBundle\Checker\Mailer\SmtpMailerChecker;
use Umanit\LifePageBundle\Checker\Mailer\SwiftmailerChecker;
use Umanit\LifePageBundle\Checker\Messenger\MessengerChecker;

class DefineCheckersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $this->setDatabaseChecker($container);
        $this->setMailerChecker($container);
        $this->setMessengerChecker($container);
        $this->setElasticsearchChecker($container);
    }

    private function setDatabaseChecker(ContainerBuilder $container): void
    {
        if ($container->has('doctrine.orm.default_entity_manager')) {
            $definition = new Definition(DoctrineChecker::class);
            $definition->setArgument(0, $container->getDefinition('doctrine.orm.default_entity_manager'));
            $definition->addTag('umanit_life_page.service_checker');
            $container->setDefinition('umanit_life_page.check_database.doctrine', $definition);
        }

        if ($container->has('pomm')) {
            $definition = new Definition(PommChecker::class);
            $definition->setArgument(0, $container->getDefinition('pomm'));
            $definition->addTag('umanit_life_page.service_checker');
            $container->setDefinition('umanit_life_page.check_database.pomm', $definition);
        }
    }

    private function setMailerChecker(ContainerBuilder $container): void
    {
        if ($container->has('swiftmailer.mailer.default')) {
            $definition = new Definition(SwiftmailerChecker::class);
            $definition->setArgument(0, $container->getDefinition('swiftmailer.mailer.default'));
            $definition->addTag('umanit_life_page.service_checker');
            $container->setDefinition('umanit_life_page.check_email.swiftmailer', $definition);
        }

        if ($container->has('mailer.default_transport')) {
            $definition = new Definition(SmtpMailerChecker::class);
            $definition->setArgument(0, $container->getDefinition('mailer.default_transport'));
            $definition->addTag('umanit_life_page.service_checker');
            $container->setDefinition('umanit_life_page.check_email.smtp_mailer', $definition);
        }
    }

    private function setMessengerChecker(ContainerBuilder $container): void
    {
        foreach ($container->findTaggedServiceIds('messenger.receiver') as $serviceId => $tags) {
            $alias = null;
            foreach ($tags as $tag) {
                if (!isset($tag['alias'])) {
                    continue;
                }

                $alias = $tag['alias'];
                break;
            }

            $definition = new Definition(MessengerChecker::class);
            $definition->setArgument(0, $container->getDefinition($serviceId));
            $definition->setArgument(1, $alias);
            $definition->addTag('umanit_life_page.service_checker');
            $container->setDefinition('umanit_life_page.check_messenger.'.$alias, $definition);
        }
    }

    private function setElasticsearchChecker(ContainerBuilder $container): void
    {
        if ($container->has('fos_elastica.client.default')) {
            $definition = new Definition(FosElasticaChecker::class);
            $definition->setArgument(0, $container->getDefinition('fos_elastica.client.default'));
            $definition->addTag('umanit_life_page.service_checker');
            $container->setDefinition('umanit_life_page.check_elasticsearch.fos_elastica', $definition);
        }
    }
}
