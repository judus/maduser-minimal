<?php
/**
 * AppInterface.php
 * 7/15/17 - 8:25 PM
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
use Maduser\Minimal\Http\Contracts\RequestInterface;
use Maduser\Minimal\Http\Contracts\ResponseInterface;
use Maduser\Minimal\Routing\Contracts\RouterInterface;

/**
 * Class Modules
 *
 * @package Maduser\Minimal\Apps
 */
interface AppInterface
{
    /**
     * @return string
     */
    public function getBasePath(): string;

    /**
     * @param string $path
     *
     * @return AppInterface
     */
    public function setBasePath(string $path): AppInterface;

    /**
     * @return string
     */
    public function getConfigFile(): string;

    /**
     * @param string $path
     *
     * @return AppInterface
     */
    public function setConfigFile(string $path): AppInterface;

    /**
     * @return string
     */
    public function getBindingsFile(): string;

    /**
     * @param string $path
     *
     * @return AppInterface
     */
    public function setBindingsFile(string $path): AppInterface;

    /**
     * @return string
     */
    public function getProvidersFile(): string;

    /**
     * @param string $path
     *
     * @return AppInterface
     */
    public function setProvidersFile(string $path): AppInterface;

    /**
     * @return string
     */
    public function getRoutesFile(): string;

    /**
     * @param string $path
     *
     * @return AppInterface
     */
    public function setRoutesFile(string $path): AppInterface;

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
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface;

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response);

    /**
     * @return RouterInterface
     */
    public function getRouter(): RouterInterface;

    /**
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router);

    /**
     * @return FactoryInterface
     */
    public function getFactory(): FactoryInterface;

    /**
     * @param FactoryInterface $factory
     */
    public function setFactory(FactoryInterface $factory);

    /**
     * @return AppInterface
     */
    public function getApp(): AppInterface;

    /**
     * @param AppInterface $app
     *
     * @return AppInterface
     */
    public function setApp(AppInterface $app): AppInterface;

    /**
     * @return FactoryInterface
     */
    public function getModules(): FactoryInterface;

    /**
     * @param FactoryInterface $modules
     */
    public function setModules(FactoryInterface $modules);
}