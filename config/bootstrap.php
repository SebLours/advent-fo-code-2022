<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\DependencyInjection\AddConsoleCommandPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\ClosureLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

$container = new ContainerBuilder();

(new ClosureLoader($container))->load(static function(ContainerBuilder $container, string $env = null) {
    $composerJon = json_decode(file_get_contents(dirname(__DIR__) . '/composer.json'), true);
    $container->setParameter('application.name', $composerJon['extra']['application']['name']);
    $container->setParameter('application.version', $composerJon['extra']['application']['version']);
    $container->setParameter('application.data_path', dirname(__DIR__) . '/data');
});

$fileLoader = new PhpFileLoader($container, new FileLocator([dirname(__DIR__) . '/config']));
$fileLoader->load('container.php');

$container->registerForAutoconfiguration(Command::class)->addTag('console.command');
$container->addCompilerPass(new AddConsoleCommandPass());

$container->compile();

return $container;