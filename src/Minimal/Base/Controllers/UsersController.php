<?php namespace Maduser\Minimal\Base\Controllers;

/**
 * Class UsersController
 *
 * @package Maduser\Minimal\Base\Controllers
 */
class UsersController extends Controller
{
    /**
     * @return string
     */
    public function listUsers()
	{
		return 'Imagine a list of users';
	}

    /**
     * @param $id
     *
     * @return string
     */
    public function edit($id)
	{
		return 'Edit id ' . $id;
	}

    /**
     * @return string
     */
    public function login()
	{
		return 'Login page';
	}

    /**
     * @return string
     */
    public function create()
	{
		return 'Create form';
	}

}