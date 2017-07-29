<?php namespace Maduser\Minimal\Routers;

use Maduser\Minimal\Collections\CollectionFactoryInterface;
use Maduser\Minimal\Collections\CollectionInterface;
use Maduser\Minimal\Config\ConfigInterface;
use Maduser\Minimal\Routers\RouteNotFoundException;
use Maduser\Minimal\Http\RequestInterface;
use Maduser\Minimal\Http\ResponseInterface;
use Maduser\Minimal\Routers\RouteInterface;

/**
 * Class Router
 *
 * @package Maduser\Minimal\Routers
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
     * @var CollectionInterface
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
     * @var
     */
    private $groupNamespace;

    /**
     * @var
     */
    private $groupMiddlewares;

    /**
     * @var array
     */
    private $groupValues = [];

    /**
     * @var bool
     */
    private $isClosure = false;

    /**
     * @var \Closure
     */
    private $closure = null;

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @param RequestInterface $request
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return CollectionInterface
     */
    public function getRoutes(): CollectionInterface
    {
        return $this->routes;
    }

    /**
     * @param $path
     */
    public function setGroupUriPrefix($path)
    {
        $this->groupUriPrefix = is_null($path) || empty($path) ?
            '' : rtrim($path, '/') . '';
    }

    /**
     * @param $path
     */
    public function setGroupNamespace($path)
    {
        $this->groupNamespace = is_null($path) || empty($path) ?
            '' : rtrim($path, '\\') . '\\';
    }

    /**
     * @return mixed
     */
    public function getGroupUriPrefix()
    {
        return $this->groupUriPrefix;
    }

    /**
     * @return mixed
     */
    public function getGroupNamespace()
    {
        return $this->groupNamespace;
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
     * @return mixed
     */
    public function getGroupMiddlewares()
    {
        return is_array($this->groupMiddlewares) ?
            $this->groupMiddlewares : [$this->groupMiddlewares];
    }

    /**
     * @param mixed $groupMiddlewares
     */
    public function setGroupMiddlewares($groupMiddlewares)
    {
        $this->groupMiddlewares = $groupMiddlewares;
    }

    /**
     * @param bool|null $bool
     *
     * @return bool
     */
    public function hasClosure(bool $bool = null): bool
    {
        if (is_callable($this->getClosure())) {
            return true;
        }

        return false;
    }

    /**
     * @return \Closure
     */
    public function getClosure()
    {
        return $this->closure;
    }

    /**
     * @param \Closure $closure
     *
     * @return Router
     */
    public function setClosure(\Closure $closure = null): Router
    {
        $this->closure = $closure;

        return $this;
    }

    /**
     * Routes constructor.
     *
     * @param ConfigInterface            $config
     * @param RequestInterface           $request
     * @param RouteInterface             $route
     * @param ResponseInterface          $response
     * @param CollectionFactoryInterface $collection
     */
    public function __construct(
        ConfigInterface $config,
        RequestInterface $request,
        RouteInterface $route,
        ResponseInterface $response,
        CollectionFactoryInterface $collection
    ) {
        $this->config = $config;
        $this->request = $request;
        $this->route = $route;
        $this->response = $response;

        $this->routes = $collection->create();

        $this->routes->add($collection->create(), 'ALL')
                     ->add($collection->create(), 'POST')
                     ->add($collection->create(), 'GET')
                     ->add($collection->create(), 'PUT')
                     ->add($collection->create(), 'PATCH')
                     ->add($collection->create(), 'DELETE');
    }

    /**
     * @param                $options
     * @param \Closure       $callback
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
        $this->setGroupNamespace(null);
        $this->setGroupMiddlewares([]);
    }

    /**
     * @param                $pattern
     * @param array|\Closure $options
     * @param \Closure       $callback
     */
    public function post($pattern, $options, $callback = null)
    {
        $this->register('POST', $pattern, $options, $callback);
    }

    /**
     * @param                $pattern
     * @param array|\Closure $options
     * @param \Closure       $callback
     */
    public function get($pattern, $options, $callback = null)
    {
        $this->register('GET', $pattern, $options, $callback);
    }

    /**
     * @param                $pattern
     * @param array|\Closure $options
     * @param \Closure       $callback
     */
    public function put($pattern, $options, $callback = null)
    {
        $this->register('PUT', $pattern, $options, $callback);
    }

    /**
     * @param                $pattern
     * @param array|\Closure $options
     * @param \Closure       $callback
     */
    public function patch($pattern, $options, $callback = null)
    {
        $this->register('PATCH', $pattern, $options, $callback);
    }

    /**
     * @param                $pattern
     * @param array|\Closure $options
     * @param \Closure       $callback
     */
    public function delete($pattern, $options, $callback = null)
    {
        $this->register('DELETE', $pattern, $options, $callback);
    }

    /**
     * @param String         $requestMethod
     * @param String         $uriPattern
     * @param array|\Closure $options
     * @param \Closure       $callback
     */
    public function register(
        String $requestMethod,
        String $uriPattern,
        $options,
        $callback = null
    ) {
        if (is_null($callback) && is_callable($options)) {
            $callback = $options;
            $options = [];
        }


        $this->setClosure(null);

        extract($this->getGroupValues());

        if (!empty($this->getGroupUriPrefix())) {
            $uriPattern = !empty($uriPattern) ? '/' . ltrim($uriPattern,
                    '/') : $uriPattern;
        }

        // Direct output
        if (is_callable($callback)) {
            $this->setClosure($callback);
            /*
            // If we have a literal match, we execute the closure, send the
            // response and exit PHP
            if ($this->matchLiteral($this->getGroupUriPrefix() . $uriPattern)) {
                //$this->response->send($callback())->exit();
            }

            // If we have a wildcard  match, we pass the wildcard value to
            // the closure, execute it, send the response and exit PHP
            if ($matches = $this->matchWildcard($this->getGroupUriPrefix() . $uriPattern)) {
                $this->response->send(
                    call_user_func_array($callback, $matches)
                )->exit();
            }
            */
        }

        if (is_string($options)) {
            $options = $this->fetchControllerAndAction($options);
        }

        if (is_array($options)) {
            extract($options);
        }

        unset($options);
        unset($callback);

        $vars = compact(array_keys(get_defined_vars()));

        $vars['namespace'] = isset($vars['namespace']) ? $vars['namespace'] : $this->getGroupNamespace();
        $vars['middlewares'] = isset($vars['middlewares']) ? array_merge($this->getGroupMiddlewares(), $vars['middlewares']) : $this->getGroupMiddlewares();
        $vars['uriPrefix'] = isset($vars['uriPrefix']) ? $vars['uriPrefix'] : $this->getGroupUriPrefix();
        $vars['closure'] = isset($vars['closure']) ? $vars['closure'] : $this->getClosure();

        $route = new Route($vars);

        $uriPattern = !empty($this->getGroupUriPrefix()) ?
            $this->getGroupUriPrefix() . $uriPattern : $uriPattern;

        $this->routes->get('ALL')->add($route, strtoupper($requestMethod).'::'.$uriPattern);
        $this->routes->get(strtoupper($requestMethod))->add($route, $uriPattern);
    }

    /**
     * @param $strOrArray
     *
     * @return array
     */
    public function fetchControllerAndAction($strOrArray)
    {
        $array = [];
        if (!is_array($strOrArray)) {
            list($array['controller'], $array['action']) = explode('@',
                $strOrArray);
        } else {
            $array = $strOrArray;
        }

        return $array;
    }

    /**
     * @param string $requestMethod
     *
     * @return CollectionInterface
     */
    public function list($requestMethod = 'ALL'): CollectionInterface
    {
        return $this->routes->get($requestMethod);
    }

    /**
     * @param null $uriString
     *
     * @return RouteInterface
     * @throws RouteNotFoundException
     */
    public function fetchRoute($uriString = null): RouteInterface
    {
        // Get the current uri string
        $uriString = $uriString ? $uriString : $this->request->getUriString();

        // Get the registered routes by http request method
        $routes = $this->list(
            $this->request->getRequestMethod()
        )->getArray();
        // Look for a literal match
        if (isset($routes[$uriString])) {
            $this->route = $routes[$uriString];
            return $routes[$uriString];
        }

        // Look for wild-cards
        foreach ($routes as $key => $options) {
            if ($matches = $this->matchWildcard($key, $uriString)) {
                $routes[$key]->setParams($matches);
                $this->route = $routes[$key];
                return $routes[$key];
            }
        }

        throw new RouteNotFoundException(
            "Route for '" .$this->request->getRequestMethod() . ' '
            . $uriString."' not found", $this);
    }

    /**
     * @param      $uriPattern
     *
     * @param null $uriString
     *
     * @return bool
     */
    public function matchLiteral($uriPattern, $uriString = null)
    {
        $uriString || $uriString = $this->request->getUriString();

        return $uriPattern == $uriString;
    }

    /**
     * @param      $uriPattern
     *
     * @param null $uriString
     *
     * @return null
     */
    public function matchWildcard($uriPattern, $uriString = null)
    {
        $uriString || $uriString = $this->request->getUriString();

        // Convert wildcards to RegEx
        $pattern = str_replace(
            ':any', '.+', str_replace(':num', '[0-9]+', $uriPattern)
        );

        if (preg_match('#^' . $pattern . '$#', $uriString, $matches)) {
            array_shift($matches);

            return $matches;
        }

        return null;
    }

    /**
     * @param null $uriString
     *
     * @return RouteInterface
     */
    public function getRoute($uriString = null): RouteInterface
    {
        return $this->fetchRoute($uriString);
    }

    public function exists($uriPattern, $requestMethod = 'ALL')
    {
        $routes = $this->routes->get($requestMethod);

        if ($routes->exists($uriPattern)) {
            return true;
        }

        return false;
    }

}