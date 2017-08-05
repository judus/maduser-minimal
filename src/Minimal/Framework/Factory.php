<?php namespace Maduser\Minimal\Framework;

use Maduser\Minimal\Framework\Contracts\FactoryInterface;
use Maduser\Minimal\Framework\Factories\Contracts\ModuleFactoryInterface;
use Maduser\Minimal\Framework\Contracts\ModuleInterface;
use Maduser\Minimal\Framework\Factories\Contracts\CollectionFactoryInterface;
use Maduser\Minimal\Framework\Factories\Contracts\MinimalFactoryInterface;
use Maduser\Minimal\Collections\Contracts\CollectionInterface;
use Maduser\Minimal\Config\Contracts\ConfigInterface;
use Maduser\Minimal\Exceptions\TypeErrorException;
use Maduser\Minimal\Http\Contracts\RequestInterface;
use Maduser\Minimal\Http\Contracts\ResponseInterface;
use Maduser\Minimal\Routing\Contracts\RouterInterface;

/**
 * Class Modules
 *
 * @package Maduser\Minimal\Core
 */
class Factory implements FactoryInterface
{
    /**
     * @var string
     */
    private $basePath = 'app';

    /**
     * @var string
     */
    private $configFile = 'config/config.php';

    /**
     * @var string
     */
    private $bindingsFile = 'config/bindings.php';

    /**
     * @var string
     */
    private $providersFile = 'config/providers.php';

    /**
     * @var string
     */
    private $routesFile = 'config/routes.php';

    /**
     * @var \Maduser\Minimal\Framework\Minimal $app
     */
    protected $app;

    /**
     * @var MinimalFactoryInterface
     */
    protected $moduleFactory;
    /**
     * @var CollectionInterface
     */
    protected $collection = CollectionInterface::class;
    /**
     * @var
     */
    protected $modules = CollectionInterface::class;
    /**
     * @var ModuleInterface
     */
    protected $module = ModuleInterface::class;

    /**
     * @var MinimalFactoryInterface
     */
    protected $collectionFactory = MinimalFactoryInterface::class;

    /**
     * @var ConfigInterface
     */
    protected $config = ConfigInterface::class;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return rtrim($this->basePath, '/') . '/';
    }

    /**
     * @param string $path
     */
    public function setBasePath(string $path)
    {
        $this->basePath = $path;
    }

    /**
     * @return string
     */
    public function getConfigFile(): string
    {
        return $this->configFile;
    }

    /**
     * @param string $path
     *
     * @return FactoryInterface
     */
    public function setConfigFile(string $path): FactoryInterface
    {
        $this->configFile = $path;

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
     * @return FactoryInterface
     */
    public function setBindingsFile(string $path): FactoryInterface
    {
        $this->bindingsFile = $path;

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
     * @return FactoryInterface
     */
    public function setProvidersFile(string $path): FactoryInterface
    {
        $this->providersFile = $path;

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
     * @return FactoryInterface
     */
    public function setRoutesFile(string $path): FactoryInterface
    {
        $this->routesFile = $path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * @param mixed $app
     */
    public function setApp($app)
    {
        $this->app = $app;
    }

    /**
     * @return CollectionInterface
     */
    public function getModules(): CollectionInterface
    {
        return $this->modules;
    }

    /**
     * @param CollectionInterface $modules
     */
    public function setModules(CollectionInterface $modules)
    {
        $this->modules = $modules;
    }

    /**
     * @return MinimalFactoryInterface
     */
    public function getModuleFactory(): MinimalFactoryInterface
    {
        return $this->moduleFactory;
    }

    /**
     * @param MinimalFactoryInterface $moduleFactory
     */
    public function setModuleFactory(MinimalFactoryInterface $moduleFactory)
    {
        $this->moduleFactory = $moduleFactory;
    }

    /**
     * @return CollectionInterface
     */
    public function getCollection(): CollectionInterface
    {
        return $this->collection;
    }

    /**
     * @param CollectionInterface $collection
     */
    public function setCollection(CollectionInterface $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return ModuleInterface
     */
    public function getModule(): ModuleInterface
    {
        return $this->module;
    }

    /**
     * @param ModuleInterface $module
     */
    public function setModule(ModuleInterface $module)
    {
        $this->module = $module;
    }

    /**
     * @return MinimalFactoryInterface
     */
    public function getCollectionFactory(): MinimalFactoryInterface
    {
        return $this->collectionFactory;
    }

    /**
     * @param MinimalFactoryInterface $collectionFactory
     */
    public function setCollectionFactory(MinimalFactoryInterface $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return ConfigInterface
     */
    public function getConfig(): ConfigInterface
    {
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
     * @return RouterInterface
     */
    public function getRouter(): RouterInterface
    {
        return $this->router;
    }

    /**
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Modules constructor.
     *
     * @param ConfigInterface            $config
     * @param CollectionFactoryInterface $collectionFactory
     * @param ModuleFactoryInterface     $moduleFactory
     */
    public function __construct(
        ConfigInterface $config,
        CollectionFactoryInterface $collectionFactory,
        ModuleFactoryInterface $moduleFactory
    ) {
        $this->config = $config;
        $this->moduleFactory = $moduleFactory;
        $this->modules = $collectionFactory->create();
    }

    /**
     * @param            $name
     * @param array|null $params
     *
     * @return array
     * @throws TypeErrorException
     */
    public function register($name, array $params = null): array
    {
        $modules = [];

        if ($this->endsWith($name, '*')) {

            $name = explode('*', $name);

            isset($path) || $path = $this->config->exists(
                'paths.modules', $this->getBasePath());

            $dirs = array_filter(glob($this->config->item('paths.system'). '/' .$path . '/' . $name[0] . '*'), 'is_dir');

            foreach ($dirs as $dir) {
                $moduleName = $name[0] . basename($dir);

                if (!$this->getModules()->exists($moduleName)) {
                    $modules[] = $this->register_($moduleName, $params);
                }

            }

        } else {

            if (!$this->getModules()->exists($name)) {
                $modules[] = $this->register_($name, $params);
            }

        }

        return $modules;
    }

    public function register_($name, array $params = null): ModuleInterface
    {
        !is_array($params) || extract($params);

        isset($path) || $path = $this->config->exists(
            'paths.modules', $this->getBasePath());

        isset($bindings) || $bindings = $this->config->exists(
            'modules.bindingsFile', $this->getBindingsFile());

        isset($providers) || $providers = $this->config->exists(
            'modules.providersFile', $this->getProvidersFile());

        isset($config) || $config = $this->config->exists(
            'modules.configFile', $this->getConfigFile());

        isset($routes) || $routes = $this->config->exists(
            'modules.routesFile', $this->getRoutesFile());

        $module = new Module();
        $module->setName($name);
        $module->setBasePath(rtrim($path, '/') . '/' . $name);
        $module->setBindingsFile($module->getBasePath() . $bindings);
        $module->setProvidersFile($module->getBasePath() . $providers);
        $module->setConfigFile($module->getBasePath() . $config);
        $module->setRoutesFile($module->getBasePath() . $routes);

        $this->app->registerConfig($module->getConfigFile());
        $this->app->registerBindings($module->getBindingsFile());
        $this->app->registerProviders($module->getProvidersFile());
        $this->app->registerRoutes($module->getRoutesFile());

        $this->registerModule($module);

        return $module;
    }

    /**
     * @param ModuleInterface $module
     */
    public function registerModule(ModuleInterface $module)
    {
        $this->modules->add($module, $module->getName());
    }

    /**
     * @param $name
     *
     * @return ModuleInterface
     */
    public function get($name) : ModuleInterface
    {
        return $this->modules->get($name);
    }

    public function startsWith($haystack, $needle)
    {
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }

    public function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}
