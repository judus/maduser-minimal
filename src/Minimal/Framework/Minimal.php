<?php namespace Maduser\Minimal\Framework;

use Maduser\Minimal\Framework\Contracts\AppInterface;
use Maduser\Minimal\Framework\Contracts\FactoryInterface;
use Maduser\Minimal\Collections\Contracts\CollectionInterface;
use Maduser\Minimal\Controllers\Contracts\FrontControllerInterface;
use Maduser\Minimal\Config\Contracts\ConfigInterface;
use Maduser\Minimal\Framework\Facades\App;
use Maduser\Minimal\Framework\Facades\IOC;
use Maduser\Minimal\Http\Contracts\RequestInterface;
use Maduser\Minimal\Http\Contracts\ResponseInterface;
use Maduser\Minimal\Middlewares\Middleware;
use Maduser\Minimal\Routing\Contracts\RouterInterface;

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
    private $minimalFile = 'config/minimal.php';

    /**
     * @var
     */
    private $configFile = 'config/environment.php';

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
        $this->basePath = $basepath;

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
        $this->appPath = $appPath;

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
        $this->modulesPath = $filePath;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinimalFile()
    {
        return $this->minimalFile;
    }

    /**
     * @param mixed $minimalFile
     *
     * @return Minimal
     */
    public function setMinimalFile($minimalFile)
    {
        $this->minimalFile = $minimalFile;

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
        $this->configFile = $path;

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
        $this->providersFile = $path;

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
        $this->bindingsFile = $path;

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
        $this->routesFile = $path;

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
     * @return Middleware
     */
    public function getMiddleware($middlewares)
    {
        return IOC::resolve('Middleware', [$middlewares]);
    }

    /**
     * @return mixed
     */
    public function getModules(): FactoryInterface
    {
        if (is_null($this->modules)) {
            $this->setModules(IOC::resolve('Factory'));
        }

        return $this->modules;
    }

    /**
     * @param mixed $modules
     *
     * @return AppInterface
     */
    public function setModules(FactoryInterface $modules): AppInterface
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
    public function __construct(array $params = [], $returnInstance = false)
    {
        if (version_compare(phpversion(), '7.0.0', '<')) {
            die('Requires PHP version > 7.0.0');
        }

        extract($params);

        !isset($basepath) || $this->setBasePath($basepath);

        defined('PATH') || define('PATH', $this->getBasePath());

        !isset($app) || $this->setAppPath($app);
        !isset($minimal) || $this->setMinimalFile($minimal);
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
        $this->registerMinimal();
        $this->registerConfig();
        $this->registerRoutes();
        $this->registerModules();

        App::setInstance($this);

        return $this;
    }

    /**
     * @param null $filePath
     */
    public function registerMinimal($filePath = null)
    {
        $filePath || $filePath = $this->getMinimalFile();

        is_file($filePath) || $filePath = $this->getBasePath() . $filePath;

        if (file_exists($filePath)) {
            /** @noinspection PhpIncludeInspection */
            $configItems = require_once $filePath;

            if (is_array($configItems)) {
                foreach ($configItems as $key => $value) {
                    $this->getConfig()->item($key, $value);
                }
            }

            if ($this->getConfig()->exists('errors.error_reporting')) {
                ini_set('error_reporting',
                    $this->getConfig()->item('errors.error_reporting'));
            }

            if ($this->getConfig()->exists('errors.display_errors')) {
                ini_set('display_errors',
                    $this->getConfig()->item('errors.display_errors'));
            }

        }
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

            if (is_array($configItems)) {
                foreach ($configItems as $key => $value) {
                    if ($this->getConfig()->exists($key)) {
                        $this->getConfig()->merge($key, $value);
                    } else {
                        $this->getConfig()->item($key, $value);
                    }
                }
            }

            if ($this->getConfig()->exists('errors.error_reporting')) {
                ini_set('error_reporting',
                    $this->getConfig()->item('errors.error_reporting'));
            }

            if ($this->getConfig()->exists('errors.display_errors')) {
                ini_set('display_errors',
                    $this->getConfig()->item('errors.display_errors'));
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
            if (is_array($bindings)) {
                IOC::addBindings($bindings);
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

            if (is_array($providers)) {
                IOC::addProviders($providers);
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
            $router = $this->getRouter();

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

        /** @var Middleware $middleware */
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
        $this->terminate();
    }

    /**
     *
     */
    public function terminate()
    {
        exit();
    }
}
