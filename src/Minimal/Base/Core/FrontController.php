<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Exceptions\MethodNotExistsException;
use Maduser\Minimal\Base\Exceptions\UnresolvedDependenciesException;
use Maduser\Minimal\Base\Interfaces\FrontControllerInterface;
use Maduser\Minimal\Base\Interfaces\MinimalFactoryInterface;
use Maduser\Minimal\Base\Interfaces\ModelFactoryInterface;
use Maduser\Minimal\Base\Interfaces\RouteInterface;
use Maduser\Minimal\Base\Interfaces\ViewFactoryInterface;
use Maduser\Minimal\Base\Interfaces\ControllerFactoryInterface;
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
     * @var ResponseInterface
     */
    protected $modelFactory;

    /**
     * @var ResponseInterface
     */
    protected $viewFactory;

    /**
     * @var ResponseInterface
     */
    protected $controllerFactory;

    /**
     * @var RouteInterface
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
     * @param RouterInterface            $router
     * @param ResponseInterface          $response
     * @param ModelFactoryInterface      $modelFactory
     * @param ViewFactoryInterface       $viewFactory
     * @param ControllerFactoryInterface $controllerFactory
     */
    public function __construct(
        RouterInterface $router,
        ResponseInterface $response,
        ModelFactoryInterface $modelFactory,
        ViewFactoryInterface $viewFactory,
        ControllerFactoryInterface $controllerFactory
    ) {
        /** @var \Maduser\Minimal\Base\Core\Router $router */
        $this->router = $router;
        $this->response = $response;
        $this->modelFactory = $modelFactory;
        $this->viewFactory = $viewFactory;
        $this->controllerFactory = $controllerFactory;
        $this->route = $this->router->getRoute();
    }

    public function setLexicalsFromRoute()
    {
        //$this->setController($this->route->getController());
        $this->setAction($this->route->getAction());
        $this->setModel($this->route->getModel());
        $this->setMethod($this->route->getMethod());
        $this->setView($this->route->getView());
        $this->setParams($this->route->getParams());
    }

    public function handleModel($model, $method = null, array $params = null)
    {
        $this->setModel(
            $this->modelFactory->createInstance(
                $model,
                $this->fetchDependencies($model)
            )
        );

        if (!is_null($method)) {
            $this->setModelResult(
                $this->executeMethod($this->getModel(), $method, $params)
            );
        }

    }

    public function handleView($view, $method = null, array $params = null)
    {
        $this->setView(
            $this->viewFactory->createInstance(
                $view,
                $this->fetchDependencies($view)
            )
        );

        if (!is_null($method)) {
            $this->setViewResult(
                $this->executeMethod($this->getView(), $method)
            );
        }

    }

    public function handleController(
        $controller,
        $action = null,
        array $params = null
    ) {
        $this->setController(
            $this->controllerFactory->createInstance(
                $controller,
                $this->fetchDependencies($controller))
        );

        if (!is_null($action)) {
            $this->setControllerResult(
                $this->executeMethod($this->getController(), $action, $params)
            );
        }
    }

    public function executeMethod($class, $method, array $params = null)
    {
        if (!method_exists($class, $method)) {
            throw new MethodNotExistsException(
                "Method '" . $method . "' does not exist in "
                . get_class($class)
            );
        }

        $params = $params ? $params : [];

        return call_user_func_array([$class, $method], $params);
    }

    public function execute(RouteInterface $route = null)
    {
        $route ? $this->setRoute($route) : null;

        if (!empty($this->route->getController())) {
            $this->handleController(
                $this->route->getController(),
                $this->route->getAction(),
                $this->route->getParams()
            );
        };

        if (!empty($this->route->getModel)) {
            $this->handleModel(
                $this->route->getModel(),
                $this->route->getMethod(),
                null // TODO: implement model params
            );
        };

        if (!empty($this->route->getView())) {
            $this->handleView(
                $this->route->getView(),
                null, // TODO: implement view method
                null // TODO: implement view params
            );
        };

        return $this;
    }

    public function fetchDependencies($class)
    {
        $reflected = new \ReflectionClass($class);

        $params = [];
        if ($constructor = $reflected->getConstructor()) {
            $params = $constructor->getParameters();
        }

        $dependencies = [];

        // Naaaaah...really, that's not what I mean!!
        // ...and it's never going to stay minimal
        // TODO: Service providers
        foreach ($params as $param) {

            $requiredInterface = $param->getClass()->name;

            foreach (IOC::$registry as $key => $registeredClass) {

                $reflectedIocItem = new \ReflectionClass($registeredClass);

                if ($reflectedIocItem->name == 'Closure') {
                    $testObject = IOC::resolve($key);
                    $testObject = new \ReflectionClass($testObject);
                } else {
                    $testObject = $reflectedIocItem;
                }

                foreach ($testObject->getInterfaceNames() as $item) {

                    if ($item == $requiredInterface) {
                        $dependencies[$key] = IOC::resolve($key);
                    }

                }
            }
        }

        if (count($params) != count($dependencies)) {
            throw new UnresolvedDependenciesException([
                'Required' => count($params),
                'Fetched' => count($dependencies),
                'Required classes' => $params,
                'Fetched classes' => $dependencies
            ]);
        }

        return $dependencies;
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
