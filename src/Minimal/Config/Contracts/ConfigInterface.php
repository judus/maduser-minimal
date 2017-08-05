<?php
/**
 * ConfigInterface.php
 * 7/15/17 - 1:39 AM
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

namespace Maduser\Minimal\Config\Contracts;




/**
 * Class Config
 *
 * @package Maduser\Minimal\Config
 */
interface ConfigInterface
{
    /**
     * @return array
     */
    public function getItems(): array;

    /**
     * @param array $items
     *
     * @return ConfigInterface
     */
    public function setItems(array $items): ConfigInterface;

    /**
     * @param      $name
     * @param null $else
     * @param bool $literal
     *
     * @return mixed|null
     */
    public function exists($name, $else = null, $literal = false);

    /**
     * @return bool
     */
    public function isLiteral(): bool;

    /**
     * @param bool $literal
     *
     * @return ConfigInterface
     */
    public function setLiteral(bool $literal): ConfigInterface;

    /**
     * @param           $name
     * @param null      $value
     * @param null|bool $literal
     *
     * @return mixed
     * @throws KeyDoesNotExistException
     */
    public function item($name, $value = null, $literal = null);

    /**
     * @param           $name
     * @param null      $value
     * @param null|bool $literal
     *
     * @return mixed
     * @throws KeyDoesNotExistException
     */
    public function merge($name, $value = null, $literal = null);

    /**
     * @param      $name
     * @param      $array
     * @param bool $throw
     * @param null $parent
     *
     * @return mixed
     */
    public function find($name, $array, $throw = false, $parent = null);

    /**
     * @param $name
     *
     * @throws KeyDoesNotExistException
     */
    public function throwKeyDoesNotExist($name);
}