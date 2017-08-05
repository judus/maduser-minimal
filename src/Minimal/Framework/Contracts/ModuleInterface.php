<?php
/**
 * ModuleInterface.php
 * 11/18/16 - 8:36 PM
 *
 * PHP version 7
 *
 * @package    @package_name@
 * @author     Julien Duseyau <julien.duseyau@gmail.com>
 * @copyright  2016 Julien Duseyau
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

/**
 * Interface ModuleInterface
 *
 * @package Maduser\Minimal\Interfaces
 */
interface ModuleInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param $name
     */
    public function setName($name);

    /**
     * @param $path
     */
    public function setBasePath($path);

    /**
     * @return string
     */
    public function getBasePath(): string;

    /**
     * @return string
     */
    public function getBootFile(): string;

    /**
     * @param mixed $bootFile
     */
    public function setBootFile($bootFile);

    /**
     * @return string
     */
    public function getConfigFile(): string;

     /**
     * @param      $path
     */
    public function setConfigFile($path);

    /**
     * @return string
     */
    public function getBindingsFile(): string;

    /**
     * @param      $path
     */
    public function setBindingsFile($path);

    /**
     * @return string
     */
    public function getProvidersFile(): string;

    /**
     * @param      $path
     */
    public function setProvidersFile($path);

    /**
     * @return string
     */
    public function getRoutesFile(): string;

    /**
     * @param      $path
     */
    public function setRoutesFile($path);
}