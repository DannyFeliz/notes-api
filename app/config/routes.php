<?php

use Notes\Library\FactoryManager;
use Phalcon\Http\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for api.
 */
$application->get('/', [
    FactoryManager::getInstance('Notes\Controllers\IndexController'),
    'index',
]);

$application->get('/notes', [
    FactoryManager::getInstance('Notes\Controllers\NotesController'),
    'getAll',
]);

$application->post('/notes', [
    FactoryManager::getInstance('Notes\Controllers\NotesController'),
    'create',
]);


//
//$application->get('/v1/subjects/{id:[0-9]+}', [
//    FactoryManager::getInstance('Notes\Controllers\SubjectController'),
//    'getSubject',
//]);




/**
 * Route not found
 */
$application->notFound(function () use ($application) {
    $response = new Response();
    $response->setStatusCode(404, "Not Found");
    $response->setContentType('application/json', 'UTF-8');
    $response->setJsonContent([
        'message' => 'route was not found',
    ]);

    $response->send();
});
