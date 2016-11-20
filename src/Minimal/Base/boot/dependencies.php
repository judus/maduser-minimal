<?php

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Core\Collection;
use Maduser\Minimal\Base\Core\Config;
use Maduser\Minimal\Base\Core\Module;
use Maduser\Minimal\Base\Core\Modules;
use Maduser\Minimal\Base\Core\Request;
use Maduser\Minimal\Base\Core\Route;
use Maduser\Minimal\Base\Core\Router;
use Maduser\Minimal\Base\Core\Response;
use Maduser\Minimal\Base\Core\Asset;
use Maduser\Minimal\Base\Core\View;
use Maduser\Minimal\Base\Core\Controller;
use Maduser\Minimal\Base\Core\FrontController;
use Maduser\Minimal\Base\Controllers\PagesController;
use Maduser\Minimal\Base\Factories\CollectionFactory;
use Maduser\Minimal\Base\Factories\ControllerFactory;
use Maduser\Minimal\Base\Factories\ModelFactory;
use Maduser\Minimal\Base\Factories\ModuleFactory;
use Maduser\Minimal\Base\Factories\ViewFactory;

// Register the Config class as singleton
IOC::register('Config', function () {
    return new Config;
}, true);

// Register the CollectionFactory class as singleton
IOC::register('CollectionFactory', function () {
    return new CollectionFactory();
}, true);

// Register the Collection class
IOC::register('Collection', function () {
    return new Collection();
});

// Register the Request class as singleton
IOC::register('Request', function () {
    return new Request();
}, true);

// Register the Route class
IOC::register('Route', function () {
    return new Route();
});

// Register the Response class as singleton
IOC::register('Response', function () {
    return new Response();
}, true);

// Register the Asset class as singleton
IOC::register('Asset', function () {
    return new Asset();
}, true);

// Register the View class as singleton
IOC::register('View', function () {
    return new View();
}, true);

// Register the Router class as singleton
IOC::register('Router', function () {
    $route = new Router(
        IOC::resolve('Config'),
        IOC::resolve('Request'),
        IOC::resolve('Route'),
        IOC::resolve('Response'),
        IOC::resolve('View')
    );
    return $route;
}, true);

// Register the ModuleFactory class as singleton
IOC::register('ModuleFactory', function () {
    return new ModuleFactory();
}, true);

// Register the Module class
IOC::register('Module', function () {
    return new Module(
        IOC::resolve('CollectionFactory'),
        IOC::resolve('Collection')
    );
});

// Register the Modules class as singleton
IOC::register('Modules', function () {
    return new Modules(
        IOC::resolve('Config'),
        IOC::resolve('CollectionFactory'),
        IOC::resolve('Collection'),
        IOC::resolve('ModuleFactory'),
        IOC::resolve('Module'),
        IOC::resolve('Request'),
        IOC::resolve('Response'),
        IOC::resolve('Router')
    );
}, true);

// Register the ModelFactory class as singleton
IOC::register('ModelFactory', function () {
    return new ModelFactory();
}, true);

// Register the ModelFactory class as singleton
IOC::register('ViewFactory', function () {
    return new ViewFactory();
}, true);

// Register the ModelFactory class as singleton
IOC::register('ControllerFactory', function () {
    return new ControllerFactory();
}, true);

// Register the FrontController as singleton
IOC::register('FrontController', function () {
    $frontController = new FrontController(
        IOC::resolve('Router'),
        IOC::resolve('Response'),
        IOC::resolve('ModelFactory'),
        IOC::resolve('ViewFactory'),
        IOC::resolve('ControllerFactory')
    );
    return $frontController;
});
