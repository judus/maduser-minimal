<?php namespace Maduser\Minimal\Apps;

use Maduser\Minimal\Exceptions\TypeErrorException;
use Maduser\Minimal\Facades\App;
use Maduser\Minimal\Apps\AppInterface;
use Maduser\Minimal\Collections\CollectionInterface;
use Maduser\Minimal\Config\ConfigInterface;
use Maduser\Minimal\Interfaces\DispatcherInterface;
use Maduser\Minimal\Apps\FactoryInterface;
use Maduser\Minimal\Middlewares\MiddlewareInterface;
use Maduser\Minimal\Apps\MinimalAppInterface;
use Maduser\Minimal\Apps\MinimalFactoryInterface;
use Maduser\Minimal\Apps\ModuleInterface;
use Maduser\Minimal\Http\RequestInterface;
use Maduser\Minimal\Http\ResponseInterface;
use Maduser\Minimal\Routers\RouterInterface;
use Maduser\Minimal\Controllers\FrontControllerInterface;
use Maduser\Minimal\Loaders\IOC;


/**
 * Class Minimal
 *
 * @package Maduser\Minimal\Core
 */
class Minimal implements AppInterface
{
    /**
     * @var
     */
    private $basePath = '..';

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
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var AppInterface
     */
    private $app;

    /**
     * @var CollectionInterface
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
     * @return AppInterface
     */
    public function getApp(): AppInterface
    {
        return $this->app;
    }

    /**
     * @param AppInterface $app
     *
     * @return AppInterface
     */
    public function setApp(AppInterface $app): AppInterface
    {
        $this->app = $app;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBasePath(): string
    {
        return rtrim($this->basePath, '/') . '/';
    }

    /**
     * @param mixed $basepath
     *
     * @return AppInterface
     */
    public function setBasePath(string $basepath): AppInterface
    {
        $this->basePath = realpath($basepath);

        return $this;
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
     *
     * @return AppInterface
     */
    public function setAppPath(string $appPath): AppInterface
    {
        $this->appPath = realpath($appPath);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModulesPath()
    {
        return rtrim($this->modulesPath, '/') . '/';
    }

    /**
     * @param string $filePath
     *
     * @return AppInterface
     */
    public function setModulesPath(string $filePath): AppInterface
    {
        $this->modulesPath = realpath($filePath);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfigFile(): string
    {
        return $this->configFile;
    }

    /**
     * @param string $path
     *
     * @return AppInterface
     */
    public function setConfigFile(string $path): AppInterface
    {
        $this->configFile = realpath($path);

        return $this;
    }

    /**
     * @return string
     */
    public function getProvidersFile(): string
    {
        return $this->providersFile;
    }

    /**
     * @param string $path
     *
     * @return AppInterface
     */
    public function setProvidersFile(string $path): AppInterface
    {
        $this->providersFile = realpath($path);

        return $this;
    }

    /**
     * @return string
     */
    public function getBindingsFile(): string
    {
        return $this->bindingsFile;
    }

    /**
     * @param string $path
     *
     * @return AppInterface
     */
    public function setBindingsFile(string $path): AppInterface
    {
        $this->bindingsFile = realpath($path);

        return $this;
    }

    /**
     * @return string
     */
    public function getRoutesFile(): string
    {
        return $this->routesFile;
    }

    /**
     * @param string $path
     *
     * @return AppInterface
     */
    public function setRoutesFile(string $path): AppInterface
    {
        $this->routesFile = realpath($path);

        return $this;
    }

    /**
     * @return string
     */
    public function getModulesFile()
    {
        return $this->modulesFile;
    }

    /**
     * @param string $path
     *
     * @return AppInterface
     */
    public function setModulesFile(string $path): AppInterface
    {
        $this->modulesFile = realpath($path);

        return $this;
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
    public function setConfig(ConfigInterface $config)
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
    public function setRequest(RequestInterface $request)
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
    public function setResponse(ResponseInterface $response)
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
    public function setRouter(RouterInterface $router)
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
    public function getModules(): CollectionInterface
    {
        if (is_null($this->modules)) {
            $this->setModules(IOC::resolve('Collection'));
        }

        return $this->modules;
    }

    /**
     * @param mixed $modules
     *
     * @return AppInterface
     */
    public function setModules(CollectionInterface $modules): AppInterface
    {
        $this->modules = $modules;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFactory(): FactoryInterface
    {
        if (is_null($this->factory)) {
            $this->setFactory(IOC::resolve('Factory'));
        }

        return $this->factory;
    }

    /**
     * @param mixed $modulesFactory
     */
    public function setFactory(FactoryInterface $modulesFactory)
    {
        $this->factory = $modulesFactory;
    }

    /**
     * @param FrontControllerInterface $frontController
     */
    public function setFrontController(
        FrontControllerInterface $frontController
    ) {
        $this->frontController = $frontController;
    }

    /**
     * @return mixed
     */
    public function getFrontController()
    {
        /*
        if (is_null($this->frontController)) {
            $this->setFrontController(IOC::resolve('FrontController'));
        }
        */

        return IOC::resolve('FrontController');
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
     * @param bool  $returnInstance
     */
    public function __construct(array $params, $returnInstance = false)
    {
        extract($params);

        !isset($basepath) || $this->setBasePath($basepath);

        defined('PATH') || define('PATH', $this->getBasePath());

        !isset($app) || $this->setAppPath($app);
        !isset($config) || $this->setConfigFile($config);
        !isset($providers) || $this->setProvidersFile($providers);
        !isset($bindings) || $this->setBindingsFile($bindings);
        !isset($routes) || $this->setRoutesFile($routes);
        !isset($modules) || $this->setModulesFile($modules);

        $returnInstance || $this->dispatch();
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
     * @param null $filePath
     */
    public function registerConfig($filePath = null)
    {
        $filePath || $filePath = $this->getConfigFile();

        is_file($filePath) || $filePath = $this->getBasePath() . $filePath;

        if (file_exists($filePath)) {
            /** @noinspection PhpIncludeInspection */
            $configItems = require_once $filePath;

            foreach ($configItems as $key => $value) {
                $this->getConfig()->item($key, $value);
            }
        }
    }

    /**
     * @param null $filePath
     */
    public function registerBindings($filePath = null)
    {
        $filePath || $filePath = $this->getBindingsFile();
        is_file($filePath) || $filePath = $this->getBasePath() . $filePath;

        if (file_exists($filePath)) {
            /** @noinspection PhpIncludeInspection */
            $bindings = require_once $filePath;

            IOC::config('bindings', $bindings);

            foreach ($bindings as $alias => $binding) {
                IOC::bind($alias, $binding);
            }
        }
    }

    /**
     * @param null $filePath
     */
    public function registerProviders($filePath = null)
    {
        $filePath || $filePath = $this->getProvidersFile();
        is_file($filePath) || $filePath = $this->getBasePath() . $filePath;

        if (is_file($filePath)) {
            /** @noinspection PhpIncludeInspection */
            $providers = require_once $filePath;

            IOC::config('providers', $providers);

            foreach ($providers as $alias => $provider) {
                IOC::register($alias, function () use ($provider) {
                    return new $provider();
                });
                /*
                if (property_exists($this, strtolower($alias))) {
                    d($alias);
                    $this->{strtolower($alias)} = IOC::resolve($alias);
                }
                */
            }
        }
    }

    /**
     * @param $filePath
     */
    public function registerRoutes($filePath = null)
    {
        $filePath || $filePath = $this->getRoutesFile();
        is_file($filePath) || $filePath = $this->getBasePath() . $filePath;

        if (is_file($filePath)) {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $route = $this->getRouter();

            /** @noinspection PhpUnusedLocalVariableInspection */
            $response = $this->getResponse();

            /** @noinspection PhpIncludeInspection */
            require $filePath;
        }
    }

    public function registerModules($filePath = null)
    {
        $filePath || $filePath = $this->getModulesFile();
        is_file($filePath) || $filePath = $this->getBasePath() . $filePath;

        if (is_file($filePath)) {
            /** @var Factory $modules */
            $modules = $this->getFactory();
            $modules->setApp($this);

            /** @noinspection PhpIncludeInspection */
            $mods = require_once $filePath;

            if (is_array($mods)) {
                foreach ($mods as $alias => $config) {
                    $config = isset($config['path']) ? $config : ['path' => $config];
                    $modules->register($alias, $config);
                }
            }
        }
    }

    /**
     * @param null $uri
     *
     * @return $this
     */
    public function execute($uri = null)
    {
        $route = $this->getRouter()->getRoute($uri);

        /** @var DispatcherInterface $middleware */
        $middleware = $this->getMiddleware($route->getMiddlewares());

        $response = $middleware->dispatch(function () use ($route, $uri) {
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
    public function dispatch()
    {
        $this->load();
        $this->execute();
        $this->respond();
        $this->exit();
    }

    /**
     *
     */
    public function exit()
    {
        exit();
    }
}
