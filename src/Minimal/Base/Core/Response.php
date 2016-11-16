<?php namespace Minimal\Base\Core;

use Maduser\Minimal\Base\Interfaces\ResponseInterface;

/**
 * Class Response
 *
 * @package Minimal\Base\Core
 */
class Response implements ResponseInterface
{
	/**
	 * @var
	 */
	private $header;

	/**
	 * @var
	 */
	private $headers = [];

	/**
	 * @var
	 */
	private $content;

	/**
	 * @var
	 */
	private $jsonEncodeArray = true;

	/**
	 * @var
	 */
	private $jsonEncodeObject = true;

	/**
	 * @param $str
	 */
	public function setHeader($str)
	{
		header($str);
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @internal param $header
	 */
	public function addHeader($key, $value)
	{
		$this->headers[$key] = $value;
	}

	/**
	 *
	 */
	public function getHeaders()
	{
		foreach ($this->headers as $key => $value)
		{
			header($key . ': ' . $value);
		}
	}

	/**
	 * @param $content
	 *
	 * @return $this
	 */
	public function setContent($content)
	{
		$this->content = $content;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * @param null $content
	 *
	 * @return $this
	 */
	public function send($content = null)
	{
		$this->getHeaders();

		if ($content) {
			$this->setContent($content);
		}

		$content = $this->getContent();

		if (is_array($content) && $this->jsonEncodeArray) {
			$this->setHeader('Content-Type: application/json');
			$content = json_encode($content);
		}

		if (is_object($content) && $this->jsonEncodeObject) {
			$this->setHeader('Content-Type: application/json');
			$content = json_encode($content);
		}

		if (is_array($content) || is_object($content)) {
			ob_start();
			show($content);
			$content = ob_get_contents();
			ob_end_clean();
		}

		echo $content;
		return $this;
	}

	/**
	 * Exit PHP
	 */
	public function exit()
	{
		exit();
	}
}