<?php namespace Maduser\Minimal\Base\Exceptions;

use Maduser\Minimal\Base\Interfaces\ExceptionInterface;

/**
 * Class MinimalException
 *
 * @package Maduser\Minimal\Base\Exceptions
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
     * @var
     */
    protected $prettyMessage;

    /**
     * MinimalException constructor.
     *
     * @param null $message
     * @param null $data
     */
    public function __construct($message = null, $data = null)
	{
		if (!$message) {
			throw new $this('Unknown ' . get_class($this));
		}

        $this->handleError(
            $this->prettyMessage($message, $data, get_class($this)),
            $message,
            get_class($this)
        );
    }

    /**
     * @param $prettyMessage
     * @param $message
     */
    protected function handleError($prettyMessage, $message)
    {
        $this->die($prettyMessage);
    }

    /**
     * @param null $exitMessage
     */
    protected function exit($exitMessage = null)
    {
        exit($exitMessage);
    }

    /**
     * @param null $exitMessage
     */
    protected function die($exitMessage = null)
    {
        die($exitMessage);
    }

    /**
     * @param null $message
     * @param null $data
     *
     * @return mixed|string
     */
    public function prettyMessage($message = null, $data = null)
    {
        $reflected = new \ReflectionClass($this);

        $message = $message ? $message :
            'Undocumented error at line '
            . debug_backtrace()[0]['line'] . ' in '
            . debug_backtrace()[0]['file'];

        $data = $data ? $data : debug_backtrace();

        ob_start();

        ?><html><body><div class="debug_show">
            <h1><?= $reflected->getShortName() ?></h1>
            <?php if (!is_string($message) && !is_array($message)) : ?>
            <hr>
            <p class="bold"><?= $message->getMessage() ?></p>
            <hr>
            <p><span class="bold">File: </span><?= $message->getFile() ?></p>
            <p><span class="bold">Line: </span><?= $message->getLine() ?></p>
            <?php foreach ($message->getTrace() as $item) { ?>
                <hr>
                <pre><?= htmlentities(print_r($item)) ?></pre>
            <?php } ?>
            <?php else : ?>
                <?php if ($message) : ?>
                    <hr>
                    <p class="bold"><?= $message ?></p>
                    <?php if ($data) : ?>
                        <hr>
                        <pre><?= htmlentities(print_r($data)) ?></pre>
                    <?php endif ?>
                <?php endif ?>
            <?php endif ?>
        <hr>
        <p class="small"><?= get_class($this) ?></p>
        </div>
        <style>
            * {
                margin: 0;
                padding: 0;
            }

            body {
                margin: 0;
                padding: 2em;
                background-color: #ddd;
                font-family: verdana,Helvetica;
                color: #204D74;
            }

            h1 {
                font-size: 1.6em;
                font-weight: bold;
                color: #D43F3A;
            }

            p {
                font-size: 1.2em;
                margin: 0;
                padding: 0
            }

            .bold {
                font-weight: bold;
            }

            .small {
                font-size: 0.8em;
                color: #333333;
            }

            pre {
                padding: 2em;
                font-size: 0.8em;
                line-height: 1.8em;
                background: #eee;
                color: #333333;
                overflow: auto;
            }

            .debug_show hr {
                display: block;
                font-size: 1.2em;
                color: transparent;
                height: 0px;
                margin: -1px 0 1em;
                padding: 1em 0 0em;
                border-bottom: 1px dashed #333333;
            }
        </style></body></html><?php

        $content = ob_get_contents();
        ob_end_clean();
        $replace = dirname(dirname($_SERVER['DOCUMENT_ROOT']));
        $content = str_replace($replace, '...', $content);
        $content = str_replace('1</pre>', '</pre>', $content);
        return $content;
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