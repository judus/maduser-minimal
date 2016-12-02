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
$minimal = new \Maduser\Minimal\Base\Core\Minimal(true);
$minimal->load();
$request = $minimal->getRequest();
$router = $minimal->getRouter();
$uriString = $request->getUriString();
$route = $router->getRoute($uriString);
$frontController = $minimal->getFrontController();
$frontController->dispatch($route);
$minimal->setResult($frontController->getControllerResult());
$minimal->respond();
$minimal->exit();
// exits PHP