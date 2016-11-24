<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Interfaces\BaseModelInterface;
use Maduser\Minimal\Base\Interfaces\ControllerInterface;

/**
 * Class Controller
 *
 * @package Maduser\Minimal\Base\Core
 */
abstract class Controller implements ControllerInterface
{
    public function __construct() {}
}