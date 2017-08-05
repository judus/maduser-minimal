<?php
/**
 * MinimalAppInterface.php
 * 7/15/17 - 8:50 PM
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

use Maduser\Minimal\Config\Contracts\ConfigInterface;
use Maduser\Minimal\Controllers\Contracts\FrontControllerInterface;
use Maduser\Minimal\Http\Contracts\RequestInterface;
use Maduser\Minimal\Http\Contracts\ResponseInterface;
use Maduser\Minimal\Routing\Contracts\RouterInterface;

/**
 * Class Minimal
 *
 * @package Maduser\Minimal\Core
 */
interface MinimalAppInterface
{
    /**
     * @return mixed
     */
    public function getBasepath();

    /**
     * @param mixed $basepath
     */
    public function setBasepath($basepath);

    /**
     * @return mixed
     */
    public function getAppPath();

    /**
     * @param mixed $appPath
     */
    public function setAppPath($appPath);

    /**
     * @return mixed
     */
    public function getModulesPath();

    /**
     * @param string $filePath
     */
    public function setModulesPath(string $filePath);

    /**
     * @return mixed
     */
    public function getConfigFile();

    /**
     * @param string $filePath
     */
    public function setConfigFile($filePath);

    /**
     * @return string
     */
    public function getProvidersFile();

    /**
     * @param string $filePath
     */
    public function setProvidersFile($filePath);

    /**
     * @return string
     */
    public function getBindingsFile();

    /**
     * @param string $filePath
     */
    public function setBindingsFile($filePath);

    /**
     * @return string
     */
    public function getRoutesFile();

    /**
     * @param string $filePath
     */
    public function setRoutesFile($filePath);

    /**
     * @return string
     */
    public function getModulesFile();

    /**
     * @param string $filePath
     */
    public function setModulesFile($filePath);

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
     * @return mixed
     */
    public function getResponse(): ResponseInterface;

    /**
     * @param mixed $response
     */
    public function setResponse(ResponseInterface $response);

    /**
     * @return mixed
     */
    public function getRouter(): RouterInterface;

    /**
     * @param mixed $router
     */
    public function setRouter(RouterInterface $router);

    /**
     * @param          $middlewares
     *
     * @return MiddlewareInterface
     */
    public function getMiddleware($middlewares): MiddlewareInterface;

    /**
     * @return mixed
     */
    public function getModules(): FactoryInterface;

    /**
     * @param mixed $modules
     */
    public function setModules(FactoryInterface $modules);

    /**
     * @param FrontControllerInterface $frontController
     */
    public function setFrontController(FrontControllerInterface $frontController
    );

    /**
     * @return mixed
     */
    public function getFrontController();

    /**
     * @return mixed
     */
    public function getResult();

    /**
     * @param mixed $result
     */
    public function setResult($result);

    /**
     * @param null $filePath
     */
    public function registerConfig($filePath = null);

    /**
     * @param null $filePath
     */
    public function registerBindings($filePath = null);

    /**
     * @param null $filePath
     */
    public function registerProviders($filePath = null);

    /**
     * @param $filePath
     */
    public function registerRoutes($filePath = null);

    public function registerModules($filePath = null);

    /**
     *
     */
    public function load();

    /**
     * @param null $uri
     *
     * @return $this
     */
    public function execute($uri = null);

    /**
     * @return $this
     */
    public function respond();

    /**
     *
     */
    public function terminate();

    /**
     *
     */
    public function dispatch();
}