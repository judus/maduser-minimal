<?php namespace Maduser\Minimal\Base\Exceptions;

use Maduser\Minimal\Base\Interfaces\ExceptionInterface;

/**
 * Class MinimalException
 *
 * @package Minimal\Base\Exceptions
 */
abstract class MinimalException extends \Exception implements ExceptionInterface
{
	/**
	 * @var string
	 */
	protected $message = 'Unknown exception';
	/**
	 * @var
	 */
	private $string;
	/**
	 * @var int
	 */
	protected $code = 0;
	/**
	 * @var
	 */
	protected $file;
	/**
	 * @var
	 */
	protected $line;
	/**
	 * @var
	 */
	private $trace;

	/**
	 * MinimalException constructor.
	 *
	 * @param null $message
	 * @param int  $code
	 */
	public function __construct($message = null, $code = 0)
	{
		if (!$message) {
			throw new $this('Unknown ' . get_class($this));
		}
		parent::__construct($message, $code);
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
		. "{$this->getTraceAsString()}";
	}
}