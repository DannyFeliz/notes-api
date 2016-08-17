<?php

use Phalcon\Loader;

$loader = new Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces([
    'Notes\Controllers' => $config->application->controllersDir,
    'Notes\Models'          => $config->application->modelsDir,
    'Notes\Library'     => $config->application->libraryDir,
    'Notes\Security'        => $config->application->libraryDir . 'Security',
    'Dashi'                 => $config->application->libraryDir
]);

$loader->register();