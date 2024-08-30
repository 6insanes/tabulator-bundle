<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use DeviantLab\TabulatorBundle\Controller\TableController;
use DeviantLab\TabulatorBundle\TableFactory;
use DeviantLab\TabulatorBundle\TableTwigExtension;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

return function(ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(TableTwigExtension::class)
        ->tag('twig.extension');

    $services->set('deviantlab.tabulator.table_type_locator', ServiceLocator::class)
        ->args([tagged_iterator('deviantlab.tabulator.table_type')])
        ->tag('container.service_locator');

    $services->set('deviantlab.tabulator.table_type_locator_by_name', ServiceLocator::class)
        ->args([tagged_iterator('deviantlab.tabulator.table_type', defaultIndexMethod: 'getName')])
        ->tag('container.service_locator');

    $services->set(TableFactory::class)
        ->args([
            service(UrlGeneratorInterface::class),
            service('deviantlab.tabulator.table_type_locator'),
        ]);

    $services->set(TableController::class)
        ->args([
            service('deviantlab.tabulator.table_type_locator_by_name'),
            service(ManagerRegistry::class),
            service(SerializerInterface::class),
        ])
        ->tag('controller.service_arguments');
};
