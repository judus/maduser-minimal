<?php
/**
 * FactoryInterface.php
 * 7/16/17 - 12:08 AM
 *
 * PHP version 7
 *
 * @package    @package_name@
 * @author     Julien Duseyau <julien.duseyau@gmail.com>
 * @copyright  2017 Julien Duseyau
 * @license    https://opensource.org/licenses/MIT
 * @version    Release: @package_version@
 *
 * The MIT License (MIT)
 *
 * Copyright (c) Julien Duseyau <julien.duseyau@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Maduser\Minimal\Framework\Contracts;

use Maduser\Minimal\Collections\Contracts\CollectionInterface;
use Maduser\Minimal\Config\Contracts\ConfigInterface;
use Maduser\Minimal\Exceptions\TypeErrorException;
use Maduser\Minimal\Framework\Factories\Contracts\MinimalFactoryInterface;
use Maduser\Minimal\Http\Contracts\RequestInterface;
use Maduser\Minimal\Http\Contracts\ResponseInterface;
use Maduser\Minimal\Routing\Contracts\RouterInterface;

/**
 * Class Modules
 *
 * @package Maduser\Minimal\Core
 */
interface FactoryInterface
{
    /**
     * @return string
     */
    public function getBasePath(): string;

    /**
     * @param string $path
     */
    public function setBasePath(string $path);

    /**
     * @return string
     */
    public function getConfigFile(): string;

    /**
     * @param string $path
     *
     * @return FactoryInterface
     */
    public function setConfigFile(string $path): FactoryInterface;

    /**
     * @return string
     */
    public function getBindingsFile(): string;

    /**
     * @param string $path
     *
     * @return FactoryInterface
     */
    public function setBindingsFile(string $path): FactoryInterface;

    /**
     * @return string
     */
    public function getProvidersFile(): string;

    /**
     * @param string $path
     *
     * @return FactoryInterface
     */
    public function setProvidersFile(string $path): FactoryInterface;

    /**
     * @return string
     */
    public function getRoutesFile(): string;

    /**
     * @param string $path
     *
     * @return FactoryInterface
     */
    public function setRoutesFile(string $path): FactoryInterface;

    /**
     * @return mixed
     */
    public function getApp();

    /**
     * @param mixed $app
     */
    public function setApp($app);

    /**
     * @return CollectionInterface
     */
    public function getModules(): CollectionInterface;

    /**
     * @param CollectionInterface $modules
     */
    public function setModules(CollectionInterface $modules);

    /**
     * @return MinimalFactoryInterface
     */
    public function getModuleFactory(): MinimalFactoryInterface;

    /**
     * @param MinimalFactoryInterface $moduleFactory
     */
    public function setModuleFactory(MinimalFactoryInterface $moduleFactory);

    /**
     * @return CollectionInterface
     */
    public function getCollection(): CollectionInterface;

    /**
     * @param CollectionInterface $collection
     */
    public function setCollection(CollectionInterface $collection);

    /**
     * @return ModuleInterface
     */
    public function getModule(): ModuleInterface;

    /**
     * @param ModuleInterface $module
     */
    public function setModule(ModuleInterface $module);

    /**
     * @return MinimalFactoryInterface
     */
    public function getCollectionFactory(): MinimalFactoryInterface;

    /**
     * @param MinimalFactoryInterface $collectionFactory
     */
    public function setCollectionFactory(
        MinimalFactoryInterface $collectionFactory
    );

    /**
     * @return ConfigInterface
     */
    public function getConfig(): ConfigInterface;

    /**
     * @param ConfigInterface $config
     */
    public function setConfig(ConfigInterface $config);

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface;

    /**
     * @param RequestInterface $request
     */
    public function setRequest(RequestInterface $request);

    /**
     * @return RouterInterface
     */
    public function getRouter(): RouterInterface;

    /**
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router);

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface;

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response);

    /**
     * @param            $name
     * @param array|null $params
     *
     * @return array
     * @throws TypeErrorException
     */
    public function register($name, array $params = null): array;

    /**
     * @param            $name
     * @param array|null $params
     *
     * @return ModuleInterface
     * @throws TypeErrorException
     */
    public function register_($name, array $params = null): ModuleInterface;


    /**
     * @param ModuleInterface $module
     */
    public function registerModule(ModuleInterface $module);

    /**
     * @param $name
     *
     * @return ModuleInterface
     */
    public function get($name): ModuleInterface;
}