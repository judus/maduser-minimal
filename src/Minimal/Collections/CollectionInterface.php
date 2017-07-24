<?php
/**
 * CollectionInterface.php
 * 7/15/17 - 1:46 AM
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

namespace Maduser\Minimal\Collections;

/**
 * Class Collection
 *
 * @package Maduser\Minimal\Collections
 */
interface CollectionInterface
{
    /**
     * @param      $obj
     * @param null $key
     *
     * @return CollectionInterface
     */
    public function add($obj, $key = null): CollectionInterface;

    /**
     * @param $key
     *
     * @throws InvalidKeyException
     */
    public function delete($key);

    /**
     * @param $key
     *
     * @return mixed
     * @throws InvalidKeyException
     */
    public function get($key);

    /**
     * @param null $key
     *
     * @return int
     */
    public function count($key = null);

    /**
     * @param null $key
     *
     * @return mixed
     */
    public function extract($key);

    /**
     * @return mixed
     */
    public function first();

    /**
     * @return array
     */
    public function getArray();
}