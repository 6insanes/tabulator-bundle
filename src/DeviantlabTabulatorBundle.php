<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class DeviantlabTabulatorBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $builder->autowire(TableTwigExtension::class)
            ->addTag('twig.extension');
    }
}
