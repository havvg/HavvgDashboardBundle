<?php

namespace Havvg\Bundle\DashboardBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class HavvgDashboardExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));

        $processor     = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);

        if (!empty($config['twig'])) {
            $loader->load('twig.yml');

            $rendererOptions = array(
                'template' => $config['twig']['template'],
            );

            if (!empty($config['twig']['default_block'])) {
                $rendererOptions['default_block'] = $config['twig']['default_block'];
            }

            $container->getDefinition('havvg_dashboard.renderer.twig')
                ->addMethodCall('configure', array(
                    $rendererOptions,
                ));
            ;
        }
    }
}
