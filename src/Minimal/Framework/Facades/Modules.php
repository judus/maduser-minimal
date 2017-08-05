<?php namespace Maduser\Minimal\Framework\Facades;

use Maduser\Minimal\Framework\Factory as CoreModules;
use Maduser\Minimal\Collections\Contracts\CollectionInterface;
use Maduser\Minimal\Config\Contracts\ConfigInterface;
use Maduser\Minimal\Framework\Factories\Contracts\MinimalFactoryInterface;
use Maduser\Minimal\Framework\Contracts\ModuleInterface;
use Maduser\Minimal\Http\Contracts\RequestInterface;
use Maduser\Minimal\Http\Contracts\ResponseInterface;
use Maduser\Minimal\Routing\Contracts\RouterInterface;

class Modules extends Facade
{
    public static $instance;

    /**
     * @return string
     */
    public static function getPath(): string
    {
        return self::call();
    }

    /**
     * @param string $path
     *
     * @return CoreModules
     */
    public static function setPath(string $path): CoreModules
    {
        return self::call();
    }

    /**
     * @return string
     */
    public static function getConfigs(): string
    {
        return self::call();
    }

    /**
     * @param string $configs
     *
     * @return CoreModules
     */
    public static function setConfigs(string $configs): CoreModules
    {
        return self::call();
    }

    /**
     * @return string
     */
    public static function getBindings(): string
    {
        return self::call();
    }

    /**
     * @param string $bindings
     *
     * @return CoreModules
     */
    public static function setBindings(string $bindings): CoreModules
    {
        return self::call();
    }

    /**
     * @return string
     */
    public static function getProviders(): string
    {
        return self::call();
    }

    /**
     * @param string $providers
     *
     * @return CoreModules
     */
    public static function setProviders(string $providers
    ): CoreModules {
        return self::call();
    }

    /**
     * @return string
     */
    public static function getRoutes(): string
    {
        return self::call();
    }

    /**
     * @param string $routes
     *
     * @return CoreModules
     */
    public static function setRoutes(string $routes): CoreModules
    {
        return self::call();
    }

    /**
     * @return mixed
     */
    public static function getApp()
    {
        return self::call();
    }

    /**
     * @param mixed $app
     *
     * @return mixed
     */
    public static function setApp($app)
    {
        return self::call();
    }

    /**
     * @return CollectionInterface
     */
    public static function getModules(): CollectionInterface
    {
        return self::call();
    }

    /**
     * @param CollectionInterface $modules
     *
     * @return mixed
     */
    public static function setModules(CollectionInterface $modules)
    {
        return self::call();
    }

    /**
     * @return MinimalFactoryInterface
     */
    public static function getModuleFactory(): MinimalFactoryInterface
    {
        return self::call();
    }

    /**
     * @param MinimalFactoryInterface $moduleFactory
     *
     * @return mixed
     */
    public static function setModuleFactory(MinimalFactoryInterface $moduleFactory)
    {
        return self::call();
    }

    /**
     * @return CollectionInterface
     */
    public static function getCollection(): CollectionInterface
    {
        return self::call();
    }
    
    /**
     * @param CollectionInterface $collection
     *
     * @return mixed
     */
    public static function setCollection(CollectionInterface $collection)
    {
        return self::call();
    }

    /**
     * @return ModuleInterface
     */
    public static function getModule(): ModuleInterface
    {
        return self::call();
    }
    
    /**
     * @param ModuleInterface $module
     *
     * @return mixed
     */
    public static function setModule(ModuleInterface $module)
    {
        return self::call();
    }

    /**
     * @return MinimalFactoryInterface
     */
    public static function getCollectionFactory(): MinimalFactoryInterface
    {
        return self::call();
    }
    
    /**
     * @param MinimalFactoryInterface $collectionFactory
     *
     * @return mixed
     */
    public static function setCollectionFactory(
        MinimalFactoryInterface $collectionFactory
    ) {
        return self::call();
    }

    /**
     * @return ConfigInterface
     */
    public static function getConfig(): ConfigInterface
    {
        return self::call();
    }
    
    /**
     * @param ConfigInterface $config
     *
     * @return mixed
     */
    public static function setConfig(ConfigInterface $config)
    {
        return self::call();
    }

    /**
     * @return RequestInterface
     */
    public static function getRequest(): RequestInterface
    {
        return self::call();
    }
    
    /**
     * @param RequestInterface $request
     *
     * @return mixed
     */
    public static function setRequest(RequestInterface $request)
    {
        return self::call();
    }

    /**
     * @return RouterInterface
     */
    public static function getRouter(): RouterInterface
    {
        return self::call();
    }
    
    /**
     * @param RouterInterface $router
     *
     * @return mixed
     */
    public static function setRouter(RouterInterface $router)
    {
        return self::call();
    }

    /**
     * @return ResponseInterface
     */
    public static function getResponse(): ResponseInterface
    {
        return self::call();
    }
    
    /**
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    public static function setResponse(ResponseInterface $response)
    {
        return self::call();
    }

    /**
     * @param            $name
     * @param array|null $params
     *
     * @return array
     * @throws TypeErrorException
     */
    public static function register($name, array $params = null): array
    {
        return self::call();
    }

    /**
     * @param ModuleInterface $module
     *
     * @return mixed
     */
    public static function registerModule(ModuleInterface $module)
    {
        return self::call();
    }
    
    /**
     * @param $name
     *
     * @return ModuleInterface
     */
    public static function get($name): ModuleInterface
    {
        return self::call();
    }
}