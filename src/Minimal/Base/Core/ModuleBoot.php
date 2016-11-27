<?php namespace Maduser\Minimal\Base\Core;

/**
 * Deprecated and no longer in use
 */

use Maduser\Minimal\Base\Interfaces\ConfigInterface;
use Maduser\Minimal\Base\Interfaces\ModuleBootInterface;
use Maduser\Minimal\Base\Interfaces\RequestInterface;
use Maduser\Minimal\Base\Interfaces\ResponseInterface;
use Maduser\Minimal\Base\Interfaces\RouterInterface;

class ModuleBoot implements ModuleBootInterface
{
    public function __construct(
        ConfigInterface $config,
        RequestInterface $request,
        ResponseInterface $response,
        RouterInterface $router
    ) {

        $this->registerConfig($config, $request);
        $this->registerRoutes($config, $request, $response, $router);

    }

    public function registerConfig(
        ConfigInterface $config,
        RequestInterface $request,
        ResponseInterface $response
    ) {

    }

    public function registerRoute(
        ConfigInterface $config,
        RequestInterface $request,
        ResponseInterface $response,
        RouterInterface $route
    ) {

    }

    public function getConfig()
    {

    }

    public function getRoutes()
    {

    }

    public function execute()
    {

    }
}
