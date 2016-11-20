<?php namespace  Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Exceptions\TypeErrorException;
use Maduser\Minimal\Base\Interfaces\CollectionInterface;
use Maduser\Minimal\Base\Interfaces\ConfigInterface;
use Maduser\Minimal\Base\Interfaces\MinimalFactoryInterface;
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
     * @param ConfigInterface         $config
     * @param MinimalFactoryInterface $collectionFactory
     * @param CollectionInterface     $collection
     * @param MinimalFactoryInterface $moduleFactory
     * @param ModuleInterface         $module
     * @param RequestInterface        $request
     * @param ResponseInterface       $response
     * @param RouterInterface         $router
     */
    public function __construct(
        ConfigInterface $config,
        MinimalFactoryInterface $collectionFactory,
        CollectionInterface $collection,
        MinimalFactoryInterface $moduleFactory,
        ModuleInterface $module,
        RequestInterface $request,
        ResponseInterface $response,
        RouterInterface $router
    ) {
        $this->config = $config;
        $this->collectionFactory = $collectionFactory;
        $this->collection = $collection;
        $this->module = $module;
        $this->moduleFactory = $moduleFactory;
        $this->request = $request;
        $this->response = $response;
        $this->router = $router;

        $this->modules = $collectionFactory->create($collection);
    }

    /**
     * @param            $name
     * @param array|null $params
     *
     * @return ModuleInterface
     * @throws TypeErrorException
     */
    public function createAndRegister($name, array $params = null) : ModuleInterface
    {
        try {
            /** @var ModuleInterface $module */
            $module = $this->moduleFactory->create(
                get_class($this->module),
                [$this->collectionFactory, $this->collection]
            );
        } catch (\TypeError $e) {
            throw new TypeErrorException($e);
        }

        $module->setName($name);
        $module->setBootFile($this->config->item('module.default.bootFile'));
        $module->addConfigFile($this->config->item('module.default.configFile'));
        $module->addRouteFile($this->config->item('module.default.routeFile'));
        $this->register($module);


        $this->setupModule($module);

        return $module;
    }


    /**
     * @param ModuleInterface $module
     */
    public function setupModule(ModuleInterface $module)
    {
        $bootFile = $module->getBootFile();
        $namespaceSegment = $module->getName();

        $class = '\\Maduser\\Minimal\\'. $namespaceSegment.'\\'.$bootFile;

        if (!class_exists($class)) {
            return;
        }

        $moduleMain = new $class(
            $this->config,
            $this->request,
            $this->response,
           $this->router
        );

    }

    /**
     * @param ModuleInterface $module
     */
    public function register(ModuleInterface $module)
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





