<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class UmanitLifePageExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        // $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        // $loader->load('services.xml');
    }
}
