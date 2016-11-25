<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Interfaces\ConfigInterface;
use Maduser\Minimal\Base\Interfaces\RequestInterface;
use Maduser\Minimal\Base\Interfaces\ResponseInterface;
use Maduser\Minimal\Base\Interfaces\RouterInterface;
use Maduser\Minimal\Base\Interfaces\ModulesInterface;
use Maduser\Minimal\Base\Interfaces\FrontControllerInterface;

/**
 * Class Minimal
 *
 * @package Maduser\Minimal\Base\Core
 */
class Minimal
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var ModulesInterface
     */
    private $modules;

    /**
     * @var FrontControllerInterface
     */
    private $frontController;

    /**
     * @var
     */
    private $result;

    /**
     * @return ConfigInterface
     */
    public function getConfig(): ConfigInterface
    {
        if (is_null($this->config)) {
            $this->setConfig(IOC::resolve('Config'));
        }

        return $this->config;
    }

    /**
     * @param ConfigInterface $config
     */
    protected function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        if (is_null($this->request)) {
            $this->setRequest(IOC::resolve('Request'));
        }

        return $this->request;
    }

    /**
     * @param RequestInterface $request
     */
    protected function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getResponse(): ResponseInterface
    {
        if (is_null($this->response)) {
            $this->setResponse(IOC::resolve('Response'));
        }

        return $this->response;
    }

    /**
     * @param mixed $response
     */
    protected function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getRouter(): RouterInterface
    {
        if (is_null($this->router)) {
            $this->setRouter(IOC::resolve('Router'));
        }

        return $this->router;
    }

    /**
     * @param mixed $router
     */
    protected function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @return mixed
     */
    public function getModules(): ModulesInterface
    {
        if (is_null($this->modules)) {
            $this->setModules(IOC::resolve('Modules'));
        }

        return $this->modules;
    }

    /**
     * @param mixed $modules
     */
    protected function setModules(ModulesInterface $modules)
    {
        $this->modules = $modules;
    }

    protected function setFrontController(
        FrontControllerInterface $frontController
    ) {
        $this->frontController = $frontController;
    }

    /**
     * @return mixed
     */
    public function getFrontController()
    {
        if (is_null($this->frontController)) {
            $this->setFrontController(IOC::resolve('FrontController'));
        }

        return $this->frontController;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    public function __construct($doNotLaunch = false)
    {
        $doNotLaunch || $this->launch();
    }

    /**
     *
     */
    protected function registerProviders()
    {
        $providers = require_once __DIR__ . '/../boot/providers.php';
        foreach ($providers as $alias => $provider) {
            IOC::register($alias, function () use ($provider) {
                return new $provider();
            });
             if (property_exists($this, strtolower($alias))) {
                $this->{strtolower($alias)} = IOC::resolve($alias);
            }
        }

    }

    /**
     */
    public function registerConfig()
    {
        $configItems = require_once __DIR__ . '/../boot/config.php';
        foreach ($configItems as $key => $value) {
            $this->config->item($key, $value);
        }
    }

    public function registerBindings()
    {
        $bindings = require_once __DIR__ . '/../boot/bindings.php';
        foreach ($bindings as $alias => $binding) {
            IOC::bind($alias, $binding);
        }
    }

    /**
     * @param ConfigInterface   $config
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param RouterInterface   $route
     */
    public function registerRoutes(
        ConfigInterface $config,
        RequestInterface $request,
        ResponseInterface $response,
        RouterInterface $route
    ) {
        require __DIR__ . '/../boot/routes.php';
    }

    /**
     * @param ConfigInterface   $config
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param RouterInterface   $route
     * @param ModulesInterface  $modules
     */
    public function registerModules(
        ConfigInterface $config,
        RequestInterface $request,
        ResponseInterface $response,
        RouterInterface $route,
        ModulesInterface $modules
    ) {
        require __DIR__ . '/../boot/modules.php';
    }

    /**
     *
     */
    public function load()
    {
        $this->registerProviders();

        $this->registerConfig();

        $this->registerBindings();

        $this->registerRoutes(
            IOC::resolve('Config'),
            IOC::resolve('Request'),
            IOC::resolve('Response'),
            IOC::resolve('Router')
        );

        $this->registerModules(
            IOC::resolve('Config'),
            IOC::resolve('Request'),
            IOC::resolve('Response'),
            IOC::resolve('Router'),
            IOC::resolve('Modules')
        );

        return $this;
    }

    public function execute($uriString = null)
    {
        $request = $this->getRequest();

        $router = $this->getRouter();

        $uriString = $uriString ? $uriString : $request->getUriString();
        $route = $router->getRoute($uriString);

        $frontController = $this->getFrontController();
        $frontController->execute($route);

        $this->setResult($frontController->getControllerResult());

        return $this;
    }

    public function respond()
    {
        $response = $this->getResponse();
        $response->setContent($this->getResult())->send();

        return $this;
    }

    public function exit()
    {
        exit();
    }

    public function launch()
    {
        $this->load();
        $this->execute();
        $this->respond();
        $this->exit();
    }
}
