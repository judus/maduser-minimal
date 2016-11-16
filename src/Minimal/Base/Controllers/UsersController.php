<?php namespace Maduser\Minimal\Base\Controllers;

class UserController
{
	public function listUsers()
	{
		return 'Imagine a list of users';
	}

	public function edit($id)
	{
		return 'Edit id ' . $id;
	}

	public function login()
	{
		return 'Login page';
	}

	public function create()
	{
		return 'Create form';
	}

	public function __toString()
	{
		return 'Hello';
	}
}