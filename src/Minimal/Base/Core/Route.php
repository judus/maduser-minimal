<?php namespace Minimal\Base\Core;

use Maduser\Minimal\Base\Interfaces\RouteInterface;

/**
 * Class Route
 *
 * @package Minimal\Base\Core
 */
class Route implements RouteInterface
{
	/**
	 * @var
	 */
	private $requestMethod;

	/**
	 * @var null
	 */
	private $cache = null;

	/**
	 * @var null
	 */
	private $uriPrefix = null;

	/**
	 * @var null
	 */
	private $uriPattern = null;

	/**
	 * @var null
	 */
	private $middleware = null;

	/**
	 * @var null
	 */
	private $namespace = null;

	/**
	 * @var null
	 */
	private $controller = null;

	/**
	 * @var null
	 */
	private $action = null;

	/**
	 * @var null
	 */
	private $model = null;

	/**
	 * @var null
	 */
	private $method = null;

	/**
	 * @var null
	 */
	private $view = null;

	/**
	 * @var array
	 */
	private $params = [];

	/**
	 * @var array
	 */
	private $values = [];

	/**
	 * @return mixed
	 */
	public function getRequestMethod()
	{
		return $this->requestMethod;
	}

	/**
	 * @param mixed $requestMethod
	 */
	public function setRequestMethod($requestMethod)
	{
		$this->requestMethod = $requestMethod;
	}

	/**
	 * @return null
	 */
	public function getCache()
	{
		return $this->cache;
	}

	/**
	 * @param null $cache
	 */
	public function setCache($cache)
	{
		$this->cache = $cache;
	}

	/**
	 * @return null
	 */
	public function getUriPrefix()
	{
		return $this->uriPrefix;
	}

	/**
	 * @param $uriPrefix
	 */
	public function setUriPrefix($uriPrefix)
	{
		$this->uriPrefix = $uriPrefix;
	}

	/**
	 * @return null
	 */
	public function getUriPattern()
	{
		return $this->uriPattern;
	}

	/**
	 * @param null $uriPattern
	 */
	public function setUriPattern($uriPattern)
	{
		$this->uriPattern = $uriPattern;
	}

	/**
	 * @return null
	 */
	public function getMiddleware()
	{
		return $this->middleware;
	}

	/**
	 * @param null $middleware
	 */
	public function setMiddleware($middleware)
	{
		$this->middleware = $middleware;
	}

	/**
	 * @return null
	 */
	public function getNamespace()
	{
		return $this->namespace;
	}

	/**
	 * @param null $namespace
	 */
	public function setNamespace($namespace)
	{
		$namespace = !empty($namespace) ? rtrim($namespace, '\\') . '\\' : $namespace;
		$this->namespace = $namespace;
	}

	/**
	 * @param $controller
	 *
	 * @return $this
	 */
	public function setController($controller)
	{
		$this->controller = $controller;
		return $this;
	}

	/**
	 * @return null
	 */
	public function getController()
	{
		$controller = $this->namespace . $this->controller;

		return empty($controller) ? null : $controller;
	}

	/**
	 * @param $action
	 *
	 * @return $this
	 */
	public function setAction($action)
	{
		$this->action = $action;
		return $this;
	}

	/**
	 * @return null
	 */
	public function getAction()
	{
		return $this->action;
	}

	/**
	 * @param $method
	 *
	 * @return $this
	 */
	public function setMethod($method)
	{
		$this->method = $method;
		return $this;
	}

	/**
	 * @return null
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * @param $model
	 *
	 * @return $this
	 */
	public function setModel($model)
	{
		$this->model = $model;
		return $this;
	}

	/**
	 * @return null
	 */
	public function getModel()
	{
		return $this->model;
	}

	/**
	 * @param $params
	 *
	 * @return $this
	 */
	public function setParams($params)
	{
		$this->params = $params;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getParams()
	{
		return $this->params;
	}

	/**
	 * @return array
	 */
	public function getValues(): array
	{
		return $this->values;
	}

	/**
	 * @param array $values
	 */
	public function setValues(array $values)
	{
		$this->values = $values;
	}

	/**
	 * @param $key
	 *
	 * @return array
	 */
	public function getValue($key)
	{
		return $this->values[$key];
	}

	/**
	 * @param       $key
	 * @param array $value
	 */
	public function addValue($key, $value)
	{
		$this->values[$key] = $value;
	}

	/**
	 * @param $view
	 *
	 * @return $this
	 */
	public function setView($view)
	{
		$this->view = $view;
		return $this;
	}

	/**
	 * @return null
	 */
	public function getView()
	{
		return $this->view;
	}

	/**
	 * Route constructor.
	 *
	 * @param array|null $values
	 */
	public function __construct(array $values = null)
	{
		if ($values) {
			foreach ($values as $key => $value)
			{
				if (method_exists($this, 'set' . ucfirst($key))) {
					$this->{'set' . ucfirst($key)}($value);
				} else {
					$this->addValue($key, $value);
				}
			}
		}

	}

}