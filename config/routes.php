<?php

use DeviantLab\TabulatorBundle\Server\TableController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes): void {
    $routes->add('deviantlab_tabulatorbundle_get_data', '/{_tableName}')
        ->methods(['GET'])
        ->controller(TableController::class);
};
