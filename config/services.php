<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use DeviantLab\TabulatorBundle\Controller\TableController;
use DeviantLab\TabulatorBundle\TableFactory;
use DeviantLab\TabulatorBundle\TableTwigExtension;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

return function(ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(TableTwigExtension::class)
        ->tag('twig.extension');

    $services->set(TableFactory::class)
        ->args([
            service(UrlGeneratorInterface::class),
            tagged_locator('deviantlab.tabulator.table_type')
        ]);

    $services->set(TableController::class)
        ->args([
            tagged_locator('deviantlab.tabulator.table_type', defaultIndexMethod: 'getName'),
            service(ManagerRegistry::class),
            service(SerializerInterface::class),
        ])
        ->tag('controller.service_arguments');
};
