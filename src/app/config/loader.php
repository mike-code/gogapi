<?php

/**
 * Registering an autoloader
 */
$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
    [
        'Store' => $config->application->modelsDir
    ]
);

$loader->registerDirs(
    [
        $config->application->controllersDir
    ]
);

$loader->register();