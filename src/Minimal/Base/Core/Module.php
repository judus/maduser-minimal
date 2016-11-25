<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Interfaces\MinimalFactoryInterface;
use Maduser\Minimal\Base\Interfaces\ModuleInterface;
use Maduser\Minimal\Base\Interfaces\CollectionFactoryInterface;
use Maduser\Minimal\Base\Interfaces\CollectionInterface;

/**
 * Class Module
 *
 * @package Maduser\Minimal\Base\Core
 */
class Module implements ModuleInterface
{
    /**
     * @var
     */
    private $name;

    /**
     * @var
     */
    private $bootFile;

    /**
     * @var array
     */
    private $configFiles = CollectionInterface::class;

    /**
     * @var array
     */
    private $routeFiles = CollectionInterface::class;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getBootFile()
    {
        return $this->bootFile;
    }

    /**
     * @param mixed $bootFile
     */
    public function setBootFile($bootFile)
    {
        $this->bootFile = $bootFile;
    }

    /**
     * @return array
     */
    public function getConfigFiles(): array
    {
        return $this->configFiles;
    }

    /**
     * @param array $configFiles
     */
    public function setConfigFiles(array $configFiles)
    {
        $this->configFiles = $configFiles;
    }

    /**
     * @return array
     */
    public function getRouteFiles(): array
    {
        return $this->routeFiles;
    }

    /**
     * @param array $routeFiles
     */
    public function setRouteFiles(array $routeFiles)
    {
        $this->routeFiles = $routeFiles;
    }

    /**
     * @param      $path
     * @param null $name
     */
    public function addConfigFile($path, $name = null)
    {
        $this->configFiles->add($path);
    }

    /**
     * @param      $path
     * @param null $name
     */
    public function addRouteFile($path, $name = null)
    {
        $this->routeFiles->add($path);
    }

    public function __construct(
        CollectionFactoryInterface $collectionFactory,
        CollectionInterface $collection
    ) {
        $this->routeFiles = $collectionFactory->create(get_class($collection));
        $this->configFiles = $collectionFactory->create(get_class($collection));
    }

}