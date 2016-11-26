<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require "../../../../vendor/autoload.php";
require "../helpers/common.php";

/**
 * Example 1
 */

new \Maduser\Minimal\Base\Core\Minimal(
    realpath(__DIR__.'/../')
);
// exits PHP

/**
 * Example 2
 */

$minimal = new \Maduser\Minimal\Base\Core\Minimal(
    realpath(__DIR__ . '/../'), true
);
$minimal->load()->execute()->respond()->exit();
// exits PHP

/**
 * Example 3
 */
$benchmark1 = microtime();

$minimal = new \Maduser\Minimal\Base\Core\Minimal(true);
$minimal->load();

$request = $minimal->getRequest();
$router = $minimal->getRouter();
$uriString = $request->getUriString();

$benchmark6 = microtime();
show($benchmark6 - $benchmark1, 'Minimal loaded');

$route = $router->getRoute($uriString);

$benchmark7 = microtime();
show($benchmark7 - $benchmark6, 'Minimal fetched route');

$frontController = $minimal->getFrontController();
$frontController->execute($route);
$minimal->setResult($frontController->getControllerResult());

$benchmark9 = microtime();
show($benchmark9 - $benchmark7, 'Minimal executed frontController');

show('------ Response start ------');
$minimal->respond();
show('------ Response end --------');

$benchmark11 = microtime();
show($benchmark11 - $benchmark9, 'Minimal sent response');

show($benchmark11 - $benchmark1, 'Minimal total');

$minimal->exit();
// exits PHP