<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use DeviantLab\TabulatorBundle\Server\DoctrineHelper;
use DeviantLab\TabulatorBundle\Server\Filter;
use DeviantLab\TabulatorBundle\Server\NativeTableHandler;
use DeviantLab\TabulatorBundle\Server\OrmTableHandler;
use DeviantLab\TabulatorBundle\Server\Pagination;
use DeviantLab\TabulatorBundle\Server\Paginator;
use DeviantLab\TabulatorBundle\Server\Sorter;
use DeviantLab\TabulatorBundle\Server\TableController;
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
            tagged_iterator('deviantlab.tabulator.server.table_handler'),
            service(SerializerInterface::class),
        ])
        ->tag('controller.service_arguments');

    $services->set(DoctrineHelper::class)
        ->args([
            service(Paginator::class),
            service(Sorter::class),
            service(Filter::class),
        ]);

    $services->set(Paginator::class)
        ->args([tagged_iterator('deviantlab.tabulator.pagination.paginator')]);

    $services->set(Pagination\OrmHandler::class)
        ->tag('deviantlab.tabulator.pagination.paginator');

    $services->set(Pagination\NativeHandler::class)
        ->tag('deviantlab.tabulator.pagination.paginator');

    $services->set(Sorter::class)
        ->args([tagged_iterator('deviantlab.tabulator.pagination.sorter')]);

    $services->set(Sorter\OrmHandler::class)
        ->tag('deviantlab.tabulator.pagination.sorter');

    $services->set(Sorter\NativeHandler::class)
        ->tag('deviantlab.tabulator.pagination.sorter');

    $services->set(Filter::class)
        ->args([tagged_iterator('deviantlab.tabulator.pagination.filter')]);

    $services->set(Filter\OrmHandler::class)
        ->tag('deviantlab.tabulator.pagination.filter');

    $services->set(Filter\NativeHandler::class)
        ->tag('deviantlab.tabulator.pagination.filter');

    $services->set(OrmTableHandler::class)
        ->args([
            service(ManagerRegistry::class),
            service(DoctrineHelper::class),
        ])
        ->tag('deviantlab.tabulator.server.table_handler');

    $services->set(NativeTableHandler::class)
        ->args([
            service(ManagerRegistry::class),
            service(DoctrineHelper::class),
        ])
        ->tag('deviantlab.tabulator.server.table_handler');
};
