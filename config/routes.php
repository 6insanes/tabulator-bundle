<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use DeviantLab\TabulatorBundle\Controller\TableController;

return function (RoutingConfigurator $routes): void {
    $routes->add('deviantlab_tabulatorbundle_get_data', '/{_tableName}')
        ->methods(['GET'])
        ->controller(TableController::class);
};
