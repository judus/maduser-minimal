<?php

/**
 * Environment
 * 0 = production
 * 1 = staging
 * 2 = development
 * 3 = debug
 */
define('MINIMAL_ENVIRONMENT', 3);
define('MINIMAL_BASEDIR', dirname(realpath(__FILE__)) . '/');
define('MINIMAL_ROUTES', MINIMAL_BASEDIR . 'routes.php');

if (MINIMAL_ENVIRONMENT > 2) {
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', true);
}

/**
 * Minimal requirements
 */
require(MINIMAL_BASEDIR . "Base/Helpers/common.php");
require(MINIMAL_BASEDIR . "Base/Helpers/autoloader.php");
require(MINIMAL_BASEDIR . "Base/Core/Minimal.php");
