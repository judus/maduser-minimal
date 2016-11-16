<?php

require "../vendor/autoload.php";

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Core\Config;
use Maduser\Minimal\Base\Core\Request;
use Maduser\Minimal\Base\Core\Route;
use Maduser\Minimal\Base\Core\Router;
use Maduser\Minimal\Base\Core\Response;
use Maduser\Minimal\Base\Core\Asset;
use Maduser\Minimal\Base\Core\Template;
use Maduser\Minimal\Base\Core\Controller;
use Maduser\Minimal\Base\Core\FrontController;

use Maduser\Minimal\Base\Controllers\PageController;

// Register the Config class
IOC::register(
/**
 * @return Config
 */
    'Config', function () {
    $config = new Config;

    return $config;
});

// Register the Request class
IOC::register(
/**
 * @return Request
 */
    'Request', function () {
    $request = new Request();

    return $request;
});

// Register the Route class
IOC::register(
/**
 * @return Route
 */
    'Route', function () {
    $route = new Route();

    return $route;
});

// Register the Response class
IOC::register(
/**
 * @return Response
 */
    'Response', function () {
    $response = new Response();

    return $response;
});

// Register the Routes class
IOC::register(
/**
 * @return Router
 */
    'Router', function () {
    $response = IOC::resolve('Response');
    $route = new Router(
        IOC::resolve('Config'),
        IOC::resolve('Request'),
        IOC::resolve('Route'),
        $response
    );
    require __DIR__ . "/routes.php";

    return $route;
});

// Register the Template class
IOC::register(
/**
 * @return Template
 */
    'Template', function () {
    $template = new Template();

    return $template;
});

// Register the Asset class
IOC::register(
/**
 * @return Asset
 */
    'Asset', function () {
    $response = new Asset();

    return $response;
});


// Register the Controller class
IOC::register(
/**
 * @return Controller
 */
    'Controller', function () {
    $controller = new Controller(
        IOC::resolve('Config'),
        IOC::resolve('Request'),
        IOC::resolve('Router'),
        IOC::resolve('Route'),
        IOC::resolve('Response'),
        IOC::resolve('Template'),
        IOC::resolve('Asset')
    );

    return $controller;
});

// Register the Controller class
IOC::register(
/**
 * @return PageController
 */
    'Maduser\Minimal\Base\Controllers\PageController', function () {
    $pageController = new PageController(
        IOC::resolve('Config'),
        IOC::resolve('Request'),
        IOC::resolve('Router'),
        IOC::resolve('Route'),
        IOC::resolve('Response'),
        IOC::resolve('Template'),
        IOC::resolve('Asset')
    );

    return $pageController;
});

// Register the FrontController
IOC::register(
/**
 * @return FrontController
 */
    'FrontController', function () {
    $frontController = new FrontController(
        IOC::resolve('Router'),
        IOC::resolve('Response')
    );

    return $frontController;
});

IOC::resolve('FrontController')->execute()->respond()->exit();
