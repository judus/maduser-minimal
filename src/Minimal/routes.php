<?php

/**
 *  Route examples
 */
// Direct output
$route->get('/', function() {
	return 'Welcome!';
});

// Using controller and method
$route->get('contact', 'Maduser\Minimal\\Base\\Controllers\\PageController@contact');

// Display page for url (:any)
$route->get('(:any)', 'Maduser\Minimal\\Base\\Controllers\\PageController@getPage');

// Display dev info
$route->get('info', 'Maduser\Minimal\\Base\\Controllers\\PageController@info');

/**
 * Grouped routes example
 */
$route->group([
	// Define the class namespace for all routes in this group
	// Will be prefixed to the controllers
	'namespace' => 'Maduser\Minimal\\Base\\Controllers\\'
], function() use ($route) {

	/**
	 * Subgroup with url prefix and middleware
	 */
	$route->group([
		// Prefixes all urls in the group with 'auth/'
		'prefix' => 'auth',
		// What should be done when accessing these routes
		'middleware' => [
			// Check if the client is authorized to access this routes
			'Maduser\Minimal\\Base\\Middlewares\\checkPermission',
			// Send a email to the administrator
			'Maduser\Minimal\\Base\\Middlewares\\ReportAccess',
		]
	], function() use ($route) {

		$route->get('users', [
			'controller' => 'UserController',
			'action' => 'listUsers' // Show a list of users
		]);

		$route->get('users/create', [
			'controller' => 'UserController',
			'action' => 'createUser' // Show a empty user form
		]);

		$route->post('users', [
			'controller' => 'UserController',
			'action' => 'saveAsNew' // Save a new user
		]);

		$route->get('users/edit/(:num)', [
			'controller' => 'UserController',
			'action' => 'editUser' // Show a form with user id = (:num)
		]);

		$route->put('users/(:num)', [
			'controller' => 'UserController',
			'action' => 'saveExistingUser' // Save user with id = (:num)
		]);

		$route->delete('users/(:num)', [
			'controller' => 'UserController',
			'action' => 'deleteUser' // Delete user with id = (:num)
		]);

		/**
		 * Example with overrides and custom values
		 */
		$route->get('register', [
			// Override namespace for this route
			'namespace' => 'Maduser\Minimal\\Modules\\Auth',
			// Disable the middleware for this route
			'middleware' => null,
			// Add a custom value
			'module-path' => 'modules/auth',
			// Use controller
			'controller' => 'RegisterController',
			// Action
			'action' => 'showRegisterForm'
		]);

	});

});

/**
 *  Direct responses
 */

// Direct output
$route->get('hello/(:any)/(:any)', function($value1, $value2) {
	return 'Hello '.$value1.' '.$value2.'!';
});

// Advanced responses
$route->get('download/pdf', function ($value1, $value2) use ($response) {
	$response->addHeader('Content-Type: application/pdf');
	$response->addHeader('Content-Disposition: attachment; filename="downloaded.pdf"');
	$response->setContent(readfile('original.pdf'));
	$response->send();
});

// Caching the output
$route->get('huge/data/table', [
	// keep in cache for day: (60*60*24)
	// keep in cache forever: -1
	// disable cache: 0 or null
	'cache' => (60*60*24),
	'namespace' => 'Maduser\\\Minimal\\Base\\Controllers',
	'controller' => 'UserController',
	'action' => 'timeConsumingAction'
]);
