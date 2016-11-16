<?php namespace Maduser\Minimal\Base\Controllers;

use Maduser\Minimal\Base\Core\Controller;
use Maduser\Minimal\Base\Interfaces\ConfigInterface;
use Maduser\Minimal\Base\Interfaces\RequestInterface;
use Maduser\Minimal\Base\Interfaces\RouterInterface;
use Maduser\Minimal\Base\Interfaces\RouteInterface;
use Maduser\Minimal\Base\Interfaces\TemplateInterface;
use Maduser\Minimal\Base\Interfaces\AssetInterface;
use Maduser\Minimal\Base\Interfaces\ResponseInterface;

/**
 * Class PageController
 *
 * @package Minimal\Base\Controllers
 */
class PageController extends Controller
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
	 * @var TemplateInterface
	 */
	protected $template;
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
	 * @param TemplateInterface $template
	 * @param AssetInterface    $asset
	 */
	public function __construct(
		ConfigInterface $config,
		RequestInterface $request,
		RouterInterface $router,
		RouteInterface $route,
		ResponseInterface $response,
		TemplateInterface $template,
		AssetInterface $asset
	) {
		$this->config = $config;
		$this->request = $request;
		$this->router = $router;
		$this->route = $route;
		$this->response = $response;
		$this->template = $template;
		$this->asset = $asset;

		$this->template->setBaseDir(MINIMAL_BASEDIR.'Base/Assets');
		$this->template->setTheme('theme-name');
		$this->template->setViewDir('views');
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