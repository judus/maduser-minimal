<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Exceptions\TypeErrorException;
use Maduser\Minimal\Base\Interfaces\CollectionFactoryInterface;
use Maduser\Minimal\Base\Interfaces\CollectionInterface;
use Maduser\Minimal\Base\Interfaces\ConfigInterface;
use Maduser\Minimal\Base\Interfaces\MinimalFactoryInterface;
use Maduser\Minimal\Base\Interfaces\ModuleFactoryInterface;
use Maduser\Minimal\Base\Interfaces\ModuleInterface;
use Maduser\Minimal\Base\Interfaces\ModulesInterface;
use Maduser\Minimal\Base\Interfaces\RequestInterface;
use Maduser\Minimal\Base\Interfaces\ResponseInterface;
use Maduser\Minimal\Base\Interfaces\RouterInterface;

/**
 * Class Modules
 *
 * @package Maduser\Minimal\Base\Core
 */
class Modules implements ModulesInterface
{
    /**
     * @var \Maduser\Minimal\Base\Core\Minimal $app
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
    public function setCollectionFactory(
        MinimalFactoryInterface $collectionFactory
    ) {
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
     * @param ConfigInterface $config
     * @param CollectionFactoryInterface $collectionFactory
     * @param ModuleFactoryInterface $moduleFactory
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param RouterInterface $router
     */
    public function __construct(
        ConfigInterface $config,
        CollectionFactoryInterface $collectionFactory,
        ModuleFactoryInterface $moduleFactory,
        RequestInterface $request,
        ResponseInterface $response,
        RouterInterface $router
    ) {
        $this->config = $config;
        $this->collectionFactory = $collectionFactory;
        $this->moduleFactory = $moduleFactory;
        $this->request = $request;
        $this->response = $response;
        $this->router = $router;

        $this->modules = $collectionFactory->create();
    }

    /**
     * @param            $name
     * @param array|null $params
     *
     * @return ModuleInterface
     * @throws TypeErrorException
     */
    public function register(
        $name,
        array $params = null
    ) : ModuleInterface
    {
        if (is_array($params)) {
            extract($params);
        }

        try {
            /** @var ModuleInterface $module */
            $module = $this->moduleFactory->create();
        } catch (\TypeError $e) {
            throw new TypeErrorException($e);
        }

        $module->setName($name);
        $module->setPath($this->app->getModulesPath() . $name);

        $bindingsFile = isset($bindings) ? $bindings : $this->config->item('modules.bindingsFile');
        $module->setBindingsFile($module->getPath() . $bindingsFile);

        $providersFile = isset($providers) ? $providers : $this->config->item('modules.providersFile');
        $module->setProvidersFile($module->getPath() . $providersFile);

        $configFile = isset($config) ? $config : $this->config->item('modules.configFile');
        $module->setConfigFile($module->getPath() . $configFile);

        $routesFile = isset($routes) ? $routes : $this->config->item('modules.routesFile');
        $module->setRoutesFile($module->getPath() . $routesFile);

        /** @var \Maduser\Minimal\Base\Core\Minimal $this->app */
        $this->app->registerConfig($module->getConfigFile());
        $this->app->registerBindings($module->getBindingsFile());
        $this->app->registerProviders($module->getProvidersFile());
        $this->app->registerRoutes($module->getRoutesFile());

        /** @var \Maduser\Minimal\Base\Core\Collection $this->modules */
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
}





