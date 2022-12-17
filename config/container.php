<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application;

return function (ContainerConfigurator $configurator) {
    $services = $configurator->services();

    $services
        ->defaults()
            ->private()
            ->autowire()
            ->autoconfigure()
    ;

    $services->set('application', Application::class)
        ->args(['%application.name%', '%application.version%'])
        ->call('setCommandLoader', [service('console.command_loader')])
        ->public()
    ;

    $services->set('application.data_file_locator', FileLocator::class)
        ->args(['%application.data_path%'])
    ;

    $services->load('AdventOfCode\\', dirname(__DIR__) . '/src/*')
        ->bind('$dataFileLocator', service('application.data_file_locator'))
    ;
};
