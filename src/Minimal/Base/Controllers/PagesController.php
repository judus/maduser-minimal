<?php namespace Maduser\Minimal\Base\Controllers;

use Maduser\Minimal\Base\Core\Controller;
use Maduser\Minimal\Base\Interfaces\ConfigInterface;
use Maduser\Minimal\Base\Interfaces\RequestInterface;
use Maduser\Minimal\Base\Interfaces\RouterInterface;
use Maduser\Minimal\Base\Interfaces\RouteInterface;
use Maduser\Minimal\Base\Interfaces\ViewInterface;
use Maduser\Minimal\Base\Interfaces\AssetInterface;
use Maduser\Minimal\Base\Interfaces\ResponseInterface;

/**
 * Class PagesController
 *
 * @package Maduser\Minimal\Base\Controllers
 */
class PagesController extends Controller
{
	/**
	 * @var ConfigInterface
	 */
	protected $config;
	/**
	 * @var RequestInterface
	 */
	protected $request;
	/**
	 * @var RouterInterface
	 */
	protected $router;
	/**
	 * @var RouteInterface
	 */
	protected $route;
	/**
	 * @var ResponseInterface
	 */
	protected $response;
	/**
	 * @var ViewInterface
	 */
	protected $view;
	/**
	 * @var AssetInterface
	 */
	protected $asset;

	/**
	 * PageController constructor.
	 *
	 * @param ConfigInterface   $config
	 * @param RequestInterface  $request
	 * @param RouterInterface   $router
	 * @param RouteInterface    $route
	 * @param ResponseInterface $response
	 * @param ViewInterface $template
	 * @param AssetInterface    $asset
	 */
	public function __construct(
		ConfigInterface $config,
		RequestInterface $request,
		RouterInterface $router,
		RouteInterface $route,
		ResponseInterface $response,
		ViewInterface $view,
		AssetInterface $asset
	) {
		$this->config = $config;
		$this->request = $request;
		$this->router = $router;
		$this->route = $route;
		$this->response = $response;
		$this->view = $view;
		$this->asset = $asset;

		$this->view->setBaseDir('base/resources/views');
		$this->view->setTheme('my-theme');
		$this->view->setViewDir('views');
	}


	/**
	 * @return string
	 */
	public function welcome()
	{
		return 'Welcome to the PageController!';
	}

	/**
	 * @return string
	 */
	public function contact()
	{
		return 'Imagine a contact form here';
	}

	/**
	 * @param $uri
	 *
	 * @return string
	 */
	public function getPage($uri)
	{
		return $this->template->render('sample.php',[
			'content' => 'Would load page for ' . $uri
		]);
	}

	/**
	 *
	 */
	public function info()
	{
		show($this->config, ucfirst('config'));
		show($this->request, ucfirst('request'));
		show($this->router, ucfirst('router'));
		show($this->route, ucfirst('route'));
		show($this->response, ucfirst('response'));
		show($this->template, ucfirst('template'));
		show($this->asset, ucfirst('asset'));
	}
}