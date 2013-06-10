<?php

namespace Havvg\Bundle\DashboardBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Havvg\Bundle\DashboardBundle\DependencyInjection\Compiler\DashboardPass;

class HavvgDashboardBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DashboardPass());
    }
}
