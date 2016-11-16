<?php

spl_autoload_register(
	/**
	 * @param $class
 	 */
	function ($class)
	{
		$prefix = 'Minimal\\';

		$base_dir = MINIMAL_BASEDIR;

		$len = strlen($prefix);
		if (strncmp($prefix, $class, $len) !== 0) {
			return;
		}

		$relative_class = substr($class, $len);

		$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

		if (file_exists($file)) {
			require $file;
		}
	}
);

