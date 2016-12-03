<?php namespace Maduser\Minimal\Base\Controllers;

use Maduser\Minimal\Base\Core\Controller;
use Maduser\Minimal\Base\Interfaces\ConfigInterface;
use Maduser\Minimal\Base\Interfaces\RequestInterface;
use Maduser\Minimal\Base\Interfaces\RouterInterface;
use Maduser\Minimal\Base\Interfaces\RouteInterface;
use Maduser\Minimal\Base\Interfaces\ViewInterface;
use Maduser\Minimal\Base\Interfaces\AssetInterface;
use Maduser\Minimal\Base\Interfaces\ResponseInterface;
use Maduser\Minimal\Base\Interfaces\ModulesInterface;

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
     * @var AssetInterface
     */
    protected $modules;
    protected $module;

    /**
     * PageController constructor.
     *
     * @param ConfigInterface   $config
     * @param RequestInterface  $request
     * @param RouterInterface   $router
     * @param ResponseInterface $response
     * @param ViewInterface     $view
     * @param AssetInterface    $asset
     * @param ModulesInterface  $modules
     */
    public function __construct(
        ConfigInterface $config,
        RequestInterface $request,
        RouterInterface $router,
        ResponseInterface $response,
        ViewInterface $view,
        AssetInterface $asset,
        ModulesInterface $modules
    ) {
        $this->config = $config;
        $this->request = $request;
        $this->router = $router;
        $this->response = $response;
        $this->view = $view;
        $this->asset = $asset;
        $this->modules = $modules;

        $this->view->setBase('../resources/views');
        $this->view->setTheme('my-theme');
        //$this->view->setDir('views');
        $this->view->setLayout('layouts/my-layout');
        $this->view->share('title', 'My title');

        $this->asset->setBase('assets');
        $this->asset->setTheme('my-theme');
        $this->asset->setCssDir('css');
        $this->asset->setJsDir('js');
        $this->asset->addCss(['bootstrap.min.css', 'bootstrap-theme.min.css', 'main.css']);
        $this->asset->addJs(['vendor/modernizr-2.8.3-respond-1.4.2.min.js'], 'top');
        $this->asset->addJs(['vendor/bootstrap.min.js', 'main.js'], 'bottom');
        $this->asset->addExternalJs(['//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js'],
            'bottom');
        $this->asset->addInlineScripts('jQueryFallback', function () {
            return $this->view->render('scripts/jquery-fallback', [], true);
        });
    }


    /**
     * @return string
     */
    public function welcome($name = null)
    {
        $name = $name ? ' '.ucfirst($name) : '';

        return $this->view->render('pages/my-view', [
            'title' => 'Welcome' . $name . '!'
        ]);
    }

    /**
     * @return string
     */
    public function contact()
    {
        return $this->view->render('pages/my-view', [
            'content' => 'Imagine a contact form here'
        ]);
    }

    /**
     * @param $uri
     *
     * @return string
     */
    public function getStaticPage($uri)
    {
        return $this->view->render('pages/my-view', [
            'content' => 'Would load page ' . "'".str_replace('/', '-' , $uri)."'"
        ]);
    }

    /**
     *
     */
    public function info()
    {

        $content = show($this->config, 'Config', true);
        $content .= show($this->request, 'Request', true);
        $content .= show($this->router, 'Router', true);
        $content .= show($this->router->getRoute(), 'Route', true);
        $content .= show($this->modules, 'Modules', true);
        $content .= show($this->response, 'Response', true);
        $content .= show($this->view, 'View', true);
        $content .= show($this->asset, 'Asset', true);

        return $this->view->render('pages/my-view', [
            'content' => $content
        ]);
    }
}