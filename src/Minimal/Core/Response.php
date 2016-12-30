<?php namespace Maduser\Minimal\Core;

use Maduser\Minimal\Interfaces\ResponseInterface;

/**
 * Class Response
 *
 * @package Maduser\Minimal\Core
 */
class Response implements ResponseInterface
{
	/**
     * Holds the response content
     *
	 * @var mixed
	 */
	private $content;

	/**
     * Config option json encode if $content is array
     *
	 * @var bool
	 */
	private $jsonEncodeArray = true;

	/**
     * Config option json encode if $content is object
     *
     * @var bool
	 */
	private $jsonEncodeObject = true;

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
     * @return mixed
     */
    public function getJsonEncodeArray()
    {
        return $this->jsonEncodeArray;
    }

    /**
     * @param mixed $jsonEncodeArray
     *
     * @return $this
     */
    public function setJsonEncodeArray($jsonEncodeArray)
    {
        $this->jsonEncodeArray = $jsonEncodeArray;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getJsonEncodeObject()
    {
        return $this->jsonEncodeObject;
    }

    /**
     * @param mixed $jsonEncodeObject
     *
     * @return $this
     */
    public function setJsonEncodeObject($jsonEncodeObject)
    {
        $this->jsonEncodeObject = $jsonEncodeObject;

        return $this;
    }

    /**
     * Send a http header
     *
     * @param $str
     *
     * @return $this
     */
	public function header($str)
	{
		header($str);

        return $this;
    }

    /**
     * @param null $content
     *
     * @return $this
     */
    public function prepare($content = null)
    {
        is_null($content) || $this->setContent($content);

        $content = $this->getContent();

        $content = $this->arrayToJson($content);

        $content = $this->objectToJson($content);

        $content = $this->printRecursiveNonAlphaNum($content);

        $this->setContent($content);

        return $this;
    }

    /**
     * Prepares and send the response to the client
     *
     * @param null $content
     *
     * @return $this
     */
    public function send($content = null)
    {
        $this->prepare($content);
        $this->sendPrepared();
        return $this;
    }

    /**
     * Send the response to the client
     *
     * @return $this
     */
    public function sendPrepared()
    {
        echo $this->getContent();
        return $this;
    }

    /**
     * Encode array to json if configured
     *
     * @param $content
     *
     * @return string
     */public function arrayToJson($content = null)
    {
        if ($this->getJsonEncodeArray() && is_array($content)) {
            $this->header('Content-Type: application/json');
            return json_encode($content);
        }

        return $content;
    }

    /**
     * Encode object to json if configured
     *
     * @param $content
     *
     * @return string
     */
    public function objectToJson($content = null)
    {
        if ($this->getJsonEncodeObject() && is_object($content)) {
            $this->header('Content-Type: application/json');
            return json_encode($content);
        }

        return $content;
    }

    /**
     * Does a print_r withobjects and array recursive
     *
     * @param $content
     *
     * @return string
     */
    public function printRecursiveNonAlphaNum($content = null)
    {
        if (is_array($content) || is_object($content)) {
            ob_start();
            show($content);
            $content = ob_get_contents();
            ob_end_clean();
        }

        return $content;
    }

    /**
     * Redirect location
     *
     * @param $url
     */
    public function redirect($url)
    {
        header('Location: ' . $url);
    }

    public function status404()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        echo "<h1>404 Not Found</h1>";
        echo "The page that you have requested could not be found.";
        $this->exit();
    }

    /**
	 * Exit PHP
	 */
	public function exit()
	{
		exit();
	}
}