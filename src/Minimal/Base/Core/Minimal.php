<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Interfaces\ConfigInterface;
use Maduser\Minimal\Base\Interfaces\DispatcherInterface;
use Maduser\Minimal\Base\Interfaces\MiddlewareInterface;
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
     * @var
     */
    private $basepath = '..';

    /**
     * @var
     */
    private $appPath = 'app';

    /**
     * @var
     */
    private $modulesPath = 'app';

    /**
     * @var
     */
    private $configFile = 'config/config.php';

    /**
     * @var
     */
    private $providersFile = 'config/providers.php';

    /**
     * @var
     */
    private $bindingsFile = 'config/bindings.php';

    /**
     * @var
     */
    private $routesFile = 'config/routes.php';

    /**
     * @var
     */
    private $modulesFile = 'config/modules.php';

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
     * @return mixed
     */
    public function getBasepath()
    {
        return rtrim($this->basepath, '/') . '/';
    }

    /**
     * @param mixed $basepath
     */
    public function setBasepath($basepath)
    {
        $this->basepath = $basepath;
    }

    /**
     * @return mixed
     */
    public function getAppPath()
    {
        return rtrim($this->appPath, '/') . '/';
    }

    /**
     * @param mixed $appPath
     */
    public function setAppPath($appPath)
    {
        $this->appPath = $appPath;
    }

    /**
     * @return mixed
     */
    public function getModulesPath()
    {
        return rtrim($this->modulesPath, '/') . '/';
    }

    /**
     * @param mixed $modulesPath
     */
    public function setModulesPath($modulesPath)
    {
        $this->modulesPath = $modulesPath;
    }

    /**
     * @return mixed
     */
    public function getConfigFile()
    {
        return $this->configFile;
    }

    /**
     * @param mixed $configFile
     */
    public function setConfigFile($configFile)
    {
        $this->configFile = $configFile;
    }

    /**
     * @return mixed
     */
    public function getProvidersFile()
    {
        return $this->providersFile;
    }

    /**
     * @param mixed $providersFile
     */
    public function setProvidersFile($providersFile)
    {
        $this->providersFile = $providersFile;
    }

    /**
     * @return mixed
     */
    public function getBindingsFile()
    {
        return $this->bindingsFile;
    }

    /**
     * @param mixed $bindingsFile
     */
    public function setBindingsFile($bindingsFile)
    {
        $this->bindingsFile = $bindingsFile;
    }

    /**
     * @return mixed
     */
    public function getRoutesFile()
    {
        return $this->routesFile;
    }

    /**
     * @param mixed $routesFile
     */
    public function setRoutesFile($routesFile)
    {
        $this->routesFile = $routesFile;
    }

    /**
     * @return mixed
     */
    public function getModulesFile()
    {
        return $this->modulesFile;
    }

    /**
     * @param mixed $modulesFile
     */
    public function setModulesFile($modulesFile)
    {
        $this->modulesFile = $modulesFile;
    }

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
     * @param          $middlewares
     *
     * @return MiddlewareInterface
     */
    public function getMiddleware($middlewares)
    {
        return IOC::resolve('Middleware', [$middlewares]);
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

    /**
     * @param FrontControllerInterface $frontController
     */
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

    /**
     * Minimal constructor.
     *
     * @param array $params
     * @param bool $returnInstance
     */
    public function __construct(array $params, $returnInstance = false)
    {
        extract($params);

        !isset($basepath) || $this->setBasepath($basepath);
        !isset($app) || $this->setAppPath($app);
        !isset($config) || $this->setConfigFile($config);
        !isset($providers) || $this->setProvidersFile($providers);
        !isset($bindings) || $this->setBindingsFile($bindings);
        !isset($routes) || $this->setRoutesFile($routes);
        !isset($modules) || $this->setRoutesFile($modules);

        define('PATH', $this->getBasepath());

        // Set namespace for aliases
        IOC::setNamespace("Maduser\\Minimal\\Base\\Core\\");

        $returnInstance || $this->dispatch();
    }

    /**
     * @param null $providersFile
     */
    public function registerProviders($providersFile = null)
    {
        $providersFile = $providersFile ? $providersFile : $this->getProvidersFile();

        /** @noinspection PhpIncludeInspection */
        $providers = require_once $this->getBasepath().$providersFile;

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
     * @param null $configFile
     */
    public function registerConfig($configFile = null)
    {
        $configFile = $configFile ? $configFile : $this->getConfigFile();

        /** @noinspection PhpIncludeInspection */
        $configItems = require_once $this->getBasepath() . $configFile;

        foreach ($configItems as $key => $value) {
            $this->config->item($key, $value);
        }
    }

    /**
     * @param null $bindingsFile
     */
    public function registerBindings($bindingsFile = null)
    {
        $bindingsFile = $bindingsFile ? $bindingsFile :  $this->getBindingsFile();

        /** @noinspection PhpIncludeInspection */
        $bindings = require_once $this->getBasepath() . $bindingsFile;

        foreach ($bindings as $alias => $binding) {
            IOC::bind($alias, $binding);
        }
    }

    /**
     * @param $routesFile
     */
    public function registerRoutes($routesFile = null)
    {
        $routesFile = $routesFile ? $routesFile : $this->getRoutesFile();

        /** @noinspection PhpUnusedLocalVariableInspection */
        $route = $this->getRouter();

        /** @noinspection PhpUnusedLocalVariableInspection */
        $response = $this->getResponse();

        /** @noinspection PhpIncludeInspection */
        require $this->getBasepath() . $routesFile;
    }

    public function registerModules($modulesFile = null)
    {
        $modulesFile = $modulesFile ? $modulesFile : $this->getModulesFile();

        $modules = $this->getModules();
        $modules->setApp($this);

        /** @noinspection PhpIncludeInspection */
        require $this->getBasepath() . $modulesFile;
    }

    /**
     *
     */
    public function load()
    {
        $this->registerBindings();
        $this->registerProviders();
        $this->registerConfig();
        $this->registerRoutes();
        $this->registerModules();

        return $this;
    }

    /**
     * @param null $uri
     *
     * @return $this
     */
    public function execute($uri = null)
    {
        $uri = $uri ? $uri : $this->getRequest()->getUriString();

        $route = $this->getRouter()->getRoute($uri);

        /** @var DispatcherInterface $middleware */
        $middleware = $this->getMiddleware($route->getMiddlewares());

        $response = $middleware->dispatch(function () use ($route) {
            return $this->getFrontController()->dispatch($route)->getResult();
        });

        $this->setResult($response);

        return $this;
    }

    /**
     * @return $this
     */
    public function respond()
    {
        $response = $this->getResponse();
        $response->setContent($this->getResult())->send();

        return $this;
    }

    /**
     *
     */
    public function exit()
    {
        exit();
    }

    /**
     *
     */
    public function dispatch()
    {
        $this->load();
        $this->execute();
        $this->respond();
        $this->exit();
    }

}
