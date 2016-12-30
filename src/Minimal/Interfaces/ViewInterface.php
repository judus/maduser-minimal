<?php
/**
 * ViewInterface.php
 * 11/29/16 - 11:52 PM
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

namespace Maduser\Minimal\Interfaces;

use Maduser\Minimal\Core\View;


/**
 * Class View
 *
 * @package Maduser\Minimal\Core
 */
interface ViewInterface
{
    /**
     * @return mixed
     */
    public function getView();

    /**
     * @param mixed $view
     */
    public function setView($view);

    /**
     * @return mixed
     */
    public function getFileExt();

    /**
     * @param mixed $fileExt
     */
    public function setFileExt($fileExt);

    /**
     * @return mixed
     */
    public function getBase();

    /**
     * @param mixed $base
     */
    public function setBase($base);

    /**
     * @return mixed
     */
    public function getTheme();

    /**
     * @param mixed $theme
     */
    public function setTheme($theme);

    /**
     * @return mixed
     */
    public function getLayout();

    /**
     * @param mixed $layout
     */
    public function setLayout($layout);

    /**
     * @return array
     */
    public function getSharedData();

    /**
     * @param $key
     * @param $value
     */
    public function share($key, $value);

    /**
     * @param $key
     *
     * @return mixed
     */
    public function shared($key);

    /**
     * @param array $data
     */
    public function setData(array $data);

    /**
     * @return array
     */
    public function getData();

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value);

    /**
     * @param $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @return string
     */
    public function getPath();

    /**
     * @return string
     */
    public function getViewPath();

    /**
     * @return string
     */
    public function getLayoutPath();

    /**
     * @return bool
     */
    public function isAjax();

    /**
     * @param       $viewPath
     * @param array $data
     *
     * @return string
     */
    public function render($viewPath, array $data = null);

    /**
     * @return string
     */
    public function yield();

    /**
     * @param            $viewPath
     * @param array|null $data
     *
     * @return string
     */
    public function renderView($viewPath, array $data = null);

    /**
     * @param array|null $data
     *
     * @return string
     */
    public function renderLayout(array $data = null);

}