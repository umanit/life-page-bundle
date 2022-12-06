<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Umanit\LifePageBundle\DependencyInjection\Compiler\DefineCheckersPass;

class UmanitLifePageBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new DefineCheckersPass());
    }
}
