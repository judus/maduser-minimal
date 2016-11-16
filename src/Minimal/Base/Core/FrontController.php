<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Interfaces\FrontControllerInterface;
use Maduser\Minimal\Base\Interfaces\RouterInterface;
use Maduser\Minimal\Base\Interfaces\ResponseInterface;

/**
 * Class FrontController
 *
 * @package Maduser\Minimal\Base\Core
 */
class FrontController implements FrontControllerInterface
{
	/**
	 * @var RouterInterface
	 */
	private $router;

	/**
	 * @var ResponseInterface
	 */
	private $response;

	/**
	 * @var
	 */
	private $route;

	/**
	 * @var
	 */
	private $model;

	/**
	 * @var
	 */
	private $method;

	/**
	 * @var
	 */
	private $controller;

	/**
	 * @var
	 */
	private $action;

	/**
	 * @var
	 */
	private $view;

	/**
	 * @var
	 */
	private $result;

	/**
	 * @var
	 */
	private $modelResult;

	/**
	 * @var
	 */
	private $controllerResult;

	/**
	 * @var
	 */
	private $viewResult;

	/**
	 * @var
	 */
	private $params;

	/**
	 * @return RouterInterface
	 */
	public function getRouter(): RouterInterface
	{
		return $this->router;
	}

	/**
	 * @param RouterInterface $router
	 */
	public function setRouter(RouterInterface $router)
	{
		$this->router = $router;
	}

	/**
	 * @return ResponseInterface
	 */
	public function getResponse(): ResponseInterface
	{
		return $this->response;
	}

	/**
	 * @param ResponseInterface $response
	 */
	public function setResponse(ResponseInterface $response)
	{
		$this->response = $response;
	}

	/**
	 * @return mixed
	 */
	public function getRoute()
	{
		return $this->route;
	}

	/**
	 * @param mixed $route
	 */
	public function setRoute($route)
	{
		$this->route = $route;
	}

	/**
	 * @return mixed
	 */
	public function getModel()
	{
		return $this->model;
	}

	/**
	 * @param mixed $model
	 */
	public function setModel($model)
	{
		$this->model = $model;
	}

	/**
	 * @return mixed
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * @param mixed $method
	 */
	public function setMethod($method)
	{
		$this->method = $method;
	}

	/**
	 * @return mixed
	 */
	public function getController()
	{
		return $this->controller;
	}

	/**
	 * @param mixed $controller
	 */
	public function setController($controller)
	{
		$this->controller = $controller;
	}

	/**
	 * @return mixed
	 */
	public function getAction()
	{
		return $this->action;
	}

	/**
	 * @param mixed $action
	 */
	public function setAction($action)
	{
		$this->action = $action;
	}

	/**
	 * @return mixed
	 */
	public function getView()
	{
		return $this->view;
	}

	/**
	 * @param mixed $view
	 */
	public function setView($view)
	{
		$this->view = $view;
	}

	/**
	 * @return mixed
	 */
	public function getResult()
	{
		return ((!empty($this->viewResult)
			&& !is_null($this->viewResult)
			&& $this->viewResult !== false) ?
			$this->viewResult :
			(!empty($this->controllerResult)
				&& !is_null($this->controllerResult)
				&& $this->controllerResult !== false) ?
				$this->controllerResult : null);
	}

	/**
	 * @param mixed $result
	 */
	public function setResult($result)
	{
		$this->result = $result;
	}

	/**
	 * @return mixed
	 */
	public function getModelResult()
	{
		return $this->modelResult;
	}

	/**
	 * @param mixed $modelResult
	 */
	public function setModelResult($modelResult)
	{
		$this->modelResult = $modelResult;
	}

	/**
	 * @return mixed
	 */
	public function getControllerResult()
	{
		return $this->controllerResult;
	}

	/**
	 * @param mixed $controllerResult
	 */
	public function setControllerResult($controllerResult)
	{
		$this->controllerResult = $controllerResult;
	}

	/**
	 * @return mixed
	 */
	public function getViewResult()
	{
		return $this->viewResult;
	}

	/**
	 * @param mixed $viewResult
	 */
	public function setViewResult($viewResult)
	{
		$this->viewResult = $viewResult;
	}

	/**
	 * @return mixed
	 */
	public function getParams()
	{
		return $this->params;
	}

	/**
	 * @param mixed $params
	 */
	public function setParams($params)
	{
		$this->params = $params;
	}

	/**
	 * FrontController constructor.
	 *
	 * @param RouterInterface   $router
	 * @param ResponseInterface $response
	 */
	public function __construct(RouterInterface $router, ResponseInterface $response)
	{
		$this->router = $router;
		$this->response = $response;
		$this->route = $this->router->getRoute();
	}

	/**
	 *
	 */
	public function execute()
	{
		$this->controller = $this->route->getController();
		$this->action = $this->route->getAction();
		$this->model = $this->route->getModel();
		$this->method = $this->route->getMethod();
		$this->view = $this->route->getView();
		$this->params = $this->route->getParams();

		if (!empty($this->model)) {
			$this->model = new $this->model();
			if (!is_null($this->method)) {
				if (!method_exists($this->model, $this->method)) {
					die('Method ' . $this->method . ' does not exist in ' . get_class($this->model));
				}
				$this->modelResult = call_user_func_array([
					$this->model, $this->method
				]);
			}
		};

		if (!empty($this->controller)) {
			if (IOC::registered(basename($this->controller)))
			{
				$this->controller = IOC::resolve($this->controller);
			} else {
				$this->controller = new $this->controller();
			}

			if (!is_null($this->action)) {
				if (!method_exists($this->controller, $this->action)) {
					die('Method '.$this->action.' does not exist in '. get_class($this->controller));
				}
				$this->controllerResult = call_user_func_array([
					$this->controller, $this->action
				], $this->params);
			}

		};

		if (!empty($this->view)) {
			$this->view = new $this->view();
		};

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function respond()
	{
		$this->response->setContent($this->getResult())->send();

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function exit()
	{
		$this->response->exit();
	}
}
