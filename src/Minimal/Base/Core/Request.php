<?php namespace Minimal\Base\Core;

use Maduser\Minimal\Base\Interfaces\RequestInterface;

/**
 * Class Request
 *
 * @package Minimal\Base\Core
 */
class Request implements RequestInterface
{
	/**
	 * @var
	 */
	private $uriString;

	/**
	 * @var
	 */
	private $requestMethod;

	/**
	 * @var array
	 */
	private $segments = [];

	/**
	 * @param $str
	 */
	private function setUriString($str)
	{
		$this->uriString = $str;
	}

	/**
	 * @return mixed
	 */
	public function getUriString()
	{
		return $this->uriString;
	}

	/**
	 * @param $str
	 */
	public function setRequestMethod($str)
	{
		$this->requestMethod = $str;
	}

	/**
	 * @return mixed
	 */
	public function getRequestMethod()
	{
		return $this->requestMethod;
	}

	/**
	 * @param array $segments
	 */
	public function setSegments(array $segments)
	{
		$this->segments = $segments;
	}

	/**
	 * @return array
	 */
	public function getSegments(): array
	{
		return $this->segments;
	}

	/**
	 * Request constructor.
	 */
	public function __construct()
	{
		$this->fetchRequestMethod();
		$this->fetchUriString();
		$this->explodeSegments();
	}

	/**
	 *
	 */
	public function fetchRequestMethod()
	{
		if (isset($_POST['_method'])) {
			if (
				$_POST['_method'] == 'PUT' ||
				$_POST['_method'] == 'PATCH' ||
				$_POST['_method'] == 'DELETE'
			) {
				$this->setRequestMethod($_POST['_method']);

				return;
			}
		}

		$this->setRequestMethod($_SERVER['REQUEST_METHOD']);
	}

	/**
	 *
	 */
	public function fetchUriString()
	{
		if (php_sapi_name() == 'cli' or defined('STDIN')) {
			$this->setUriString($this->parseCliArgs());

			return;
		}

		// Fetch request string (apache)
		$uri = $_SERVER['REQUEST_URI'];

		// Remove script name (index.php) from uri
		if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0) {
			$uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
		} elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0) {
			$uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
		}

		// Further cleaning of the uri
		$uri = str_replace(array('//', '../'), '/', trim($uri, '/'));

		if (empty($uri)) {
			$uri = '/';
		}

		$this->setUriString($uri);
	}

	/**
	 * @return string
	 */
	private function parseCliArgs()
	{
		$args = array_slice($_SERVER['argv'], 1);

		return $args ? '/' . implode('/', $args) : '';
	}

	/**
	 * @param $str
	 *
	 * @return mixed
	 */
	public function filterUri($str)
	{
		$bad = array('$', '(', ')', '%28', '%29');
		$good = array('&#36;', '&#40;', '&#41;', '&#40;', '&#41;');

		return str_replace($bad, $good, $str);
	}

	/**
	 *
	 */
	public function explodeSegments()
	{
		foreach (
			explode("/", preg_replace("|/*(.+?)/*$|", "\\1", $this->uriString))
			as $val
		) {
			$val = trim($this->filterUri($val));

			if ($val != '') {
				$this->segments[] = $val;
			}
		}
	}
}