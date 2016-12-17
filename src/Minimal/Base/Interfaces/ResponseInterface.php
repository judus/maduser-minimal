<?php namespace Maduser\Minimal\Base\Interfaces;

/**
 * Interface ResponseInterface
 *
 * @package Maduser\Minimal\Base\Interfaces
 */
interface ResponseInterface
{
    /**
     * Set response content
     *
     * @param mixed $content
     *
     * @return mixed
     */
    public function setContent($content);

    /**
     * Return response content
     *
	 * @return mixed
	 */
	public function getContent();

    /**
     * Set http header
     *
     * @param $string
     *
     * @return mixed
     */
    public function header($string);

    /**
     * Send response content to client
     *
     * @param mixed|null $content
     *
     * @return $this
     */
    public function send($content = null);

    /**
     * Redirect http header location
     *
     * @param string $uri
     *
     * @return void
     */
    public function redirect($uri);

    /**
     * PHP exit()
     *
	 * @return void
	 */
	public function exit();
}