<?php
/**
 * ViewInterface.php
 * 7/15/17 - 4:47 AM
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

namespace Maduser\Minimal\Views\Contracts;

use Maduser\Minimal\Assets\Contracts\AssetsInterface;
use Maduser\Minimal\Views\Exceptions\ViewNotFoundException;

/**
 * Class View
 *
 * @package Maduser\Minimal\Libraries
 */
interface ViewInterface
{
    /**
     * @return mixed
     */
    public function getAssets();

    /**
     * @param mixed $assets
     */
    public function setAssets($assets);

    /**
     * @return mixed
     */
    public function getDir();

    /**
     * @param mixed $dir
     */
    public function setDir($dir);

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
     * View constructor.
     *
     * @param AssetsInterface $assets
     */
    public function __construct(AssetsInterface $assets = null);

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
     * @param bool  $bypass
     *
     * @return string
     */
    public function render($viewPath, array $data = null, $bypass = false);

    /**
     * @return string
     */
    public function view();

    /**
     * @param            $viewPath
     * @param array|null $data
     *
     * @return string
     * @throws ViewNotFoundException
     */
    public function renderView($viewPath, array $data = null);

    /**
     * @param array|null $data
     *
     * @return string
     */
    public function renderLayout(array $data = null);
}