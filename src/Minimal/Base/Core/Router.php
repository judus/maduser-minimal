<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Interfaces\RouterInterface;
use Maduser\Minimal\Base\Interfaces\ConfigInterface;
use Maduser\Minimal\Base\Interfaces\RequestInterface;
use Maduser\Minimal\Base\Interfaces\RouteInterface;
use Maduser\Minimal\Base\Interfaces\ResponseInterface;
use Maduser\Minimal\Base\Core\Collection;

/**
 * Class Router
 *
 * @package Maduser\Minimal\Base\Core
 */
class Router implements RouterInterface
{
	/**
	 * @var ConfigInterface
	 */
	private $config;

	/**
	 * @var RequestInterface
	 */
	private $request;

	/**
	 * @var RouteInterface
	 */
	private $route;

	/**
	 * @var RoutesCollection
	 */
	private $routesCollection;

	/**
	 * @var Routes
	 */
	private $routes;

	/**
	 * @var ResponseInterface
	 */
	private $response;

	/**
	 * @var
	 */
	private $groupUriPrefix;

	/**
	 * @var array
	 */
	private $groupValues = [];

	/**
	 * @return Request
	 */
	public function getRequest(): Request
	{
		return $this->request;
	}

	/**
	 * @param Request $request
	 */
	public function setRequest(Request $request)
	{
		$this->request = $request;
	}

	/**
	 * @param $path
	 */
	public function setGroupUriPrefix($path)
	{
		$this->groupUriPrefix = empty($path) ? '' : rtrim($path, '/') . '/';
	}

	/**
	 * @return mixed
	 */
	public function getGroupUriPrefix()
	{
		return $this->groupUriPrefix;
	}

	/**
	 * @param array $values
	 */
	public function setGroupValues(array $values)
	{
		$this->groupValues = $values;
	}

	/**
	 * @return array
	 */
	public function getGroupValues()
	{
		return $this->groupValues;
	}

	/**
	 * @param $key
	 * @param $value
	 */
	public function addGroupValue($key, $value)
	{
		$this->groupValues[$key] = $value;
	}

	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	public function getGroupValue($key)
	{
		return $this->groupValues[$key];
	}

	/**
	 * Routes constructor.
	 *
	 * @param ConfigInterface           $config
	 * @param RequestInterface          $request
	 * @param RouteInterface            $route
	 * @param ResponseInterface 		$response
	 */
	public function __construct(
		ConfigInterface $config,
		RequestInterface $request,
		RouteInterface $route,
		ResponseInterface $response
	)
	{
		$this->config = $config;
		$this->request = $request;
		$this->route = $route;
		$this->response = $response;

		$this->routes = new Collection();
		$this->routes
			->add(new Collection(), 'POST')
			->add(new Collection(), 'GET')
			->add(new Collection(), 'PUT')
			->add(new Collection(), 'PATCH')
			->add(new Collection(), 'DELETE');
	}

	/**
	 * @param                $options
	 * @param \Closure $callback
	 */
	public function group($options, \Closure $callback)
	{
		if (!is_array($options)) {

			$this->setGroupUriPrefix($options);

		} else {

			foreach ($options as $key => $value) {
				if (method_exists($this, 'setGroup' . ucfirst($key))) {
					$this->{'setGroup' . ucfirst($key)}($value);
				} else {
					$this->addGroupValue($key, $value);
				}
			}

		}

		$callback();

		$this->setGroupUriPrefix(null);
	}

	/**
	 * @param $pattern
	 * @param array|\Closure $callback
	 */
	public function post($pattern, $callback)
	{
		$this->register('POST', $pattern, $callback);
	}

	/**
	 * @param $pattern
	 * @param array|\Closure $callback
	 */
	public function get($pattern, $callback)
	{
		$this->register('GET', $pattern, $callback);
	}

	/**
	 * @param $pattern
	 * @param array|\Closure $callback
	 */
	public function put($pattern, $callback)
	{
		$this->register('PUT', $pattern, $callback);
	}

	/**
	 * @param $pattern
	 * @param array|\Closure $callback
	 */
	public function patch($pattern, $callback)
	{
		$this->register('PATCH', $pattern, $callback);
	}

	/**
	 * @param $pattern
	 * @param array|\Closure $callback
	 */
	public function delete($pattern, $callback)
	{
		$this->register('DELETE', $pattern, $callback);
	}

	/**
	 * @param String         $requestMethod
	 * @param String         $uriPattern
	 * @param array|\Closure $callback
	 */
	private function register(String $requestMethod, String $uriPattern, $callback)
	{
		extract($this->getGroupValues());

		if (is_callable($callback)) {

			if ($this->matchLiteral($this->getGroupUriPrefix().$uriPattern)) {
				$this->response->send($callback())->exit();
			}

			if ($matches = $this->matchWildcard($this->getGroupUriPrefix().$uriPattern)) {
				$this->response->send(
					call_user_func_array($callback, $matches)
				)->exit();
			}
		}

		if (is_string($callback)) {
			$callback = $this->fetchControllerAndAction($callback);
		}

		if (is_array($callback)) {
			extract($callback);
		}

		unset($callback);

		$vars = compact(array_keys(get_defined_vars()));

		$route = new Route($vars);

		$this->routes->get(strtoupper($requestMethod))->add(
			$route,
			!empty($this->getGroupUriPrefix()) ?
				$this->getGroupUriPrefix() . '/' . $uriPattern : $uriPattern
		);
	}

	/**
	 * @param $strOrArray
	 *
	 * @return array
	 */
	private function fetchControllerAndAction($strOrArray)
	{
		$array = [];
		if (!is_array($strOrArray)) {
			list($array['controller'], $array['action']) = explode('@', $strOrArray);
		} else {
			$array = $strOrArray;
		}

		return $array;
	}

	/**
	 * @param null $method
	 *
	 * @return mixed
	 */
	public function list($method = null)
	{
		return $this->routes->get($method);
	}

	/**
	 * @return Route
	 */
	private function fetchRoute()
	{
		// Get the current uri string
		$uri = $this->request->getUriString();

		// Get the registered routes by http request method
		$routes = $this->list(
			$this->request->getRequestMethod()
		)->getArray();


		// Look for a literal match
		if (isset($routes[$uri])) {
			return $routes[$uri];
		}

		// Look for wild-cards
		foreach ($routes as $key => $options)
		{
			if ($matches = $this->matchWildcard($key))
			{
				$routes[$key]->setParams($matches);

				return $routes[$key];
			}
		}

		$this->routeNotFound();
	}

    /**
     * @param $uriPattern
     *
     * @return bool
     */public function matchLiteral($uriPattern)
	{
		return $uriPattern == $this->request->getUriString();
	}

    /**
     * @param $uriPattern
     *
     * @return null
     */public function matchWildcard($uriPattern)
	{
		// Convert wildcards to RegEx
		$str = str_replace(
			':any', '.+', str_replace(':num', '[0-9]+', $uriPattern)
		);

		if (preg_match('#^' . $str . '$#',
			$this->request->getUriString(),
			$matches
		)) {
			array_shift($matches);
			return $matches;
		}
		return null;
	}

	/**
	 * @return Route
	 */
	public function getRoute()
	{
		return $this->fetchRoute();
	}

    /**
     *
     */
    public function routeNotFound()
	{
		$this->response->setHeader('HTTP/1.1 500 Internal Server Error');
		$this->response->setContent('500 Route not found');
		$this->response->send();
	}
}