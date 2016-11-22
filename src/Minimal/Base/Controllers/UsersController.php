<?php namespace Maduser\Minimal\Base\Controllers;

/**
 * Class UsersController
 *
 * @package Maduser\Minimal\Base\Controllers
 */
class UsersController
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
    public function show($id)
    {
        return 'Show user with id ' . $id;
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function edit($id)
    {
        return 'Edit user with id ' . $id;
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

    public function timeConsumingAction()
    {
        return 'timeConsumingAction()';
    }

}