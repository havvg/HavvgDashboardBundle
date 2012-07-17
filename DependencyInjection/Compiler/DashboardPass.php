<?php

namespace Havvg\Bundle\DashboardBundle\DependencyInjection\Compiler;

use Havvg\Bundle\DRYBundle\DependencyInjection\Compiler\AbstractTaggedMapCompilerPass;

class DashboardPass extends AbstractTaggedMapCompilerPass
{
    protected $mapServiceTag = 'havvg_dashboard.boardlet';
    protected $targetServiceTag = 'havvg_dashboard.dashboard';
    protected $targetMethod = 'add';
}
