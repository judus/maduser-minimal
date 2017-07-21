<?php namespace Maduser\Minimal\Database;

use PDO;
use PDOException;

/**
 * Class Database
 *
 * @package Maduser\Minimal\Libraries\Database
 */
class Database
{
    /**
     * @var array
     */
    private $connections = [];

    /**
     * @param $connectionName
     *
     * @return string
     */
    public function getConnectionName($connectionName)
    {
        if ($connectionName) {
            return $connectionName;
        }

        return 'default';
    }

    /**
     * @param null $connectionName
     *
     * @return mixed
     */
    public function connect($connectionName = null)
    {
        global $databaseConnections;

        $connectionName = $this->getConnectionName($connectionName);

        if (!isset($databaseConnections[$connectionName])) {
            die("Undefined connection '".$connectionName."'");
        }

        if (isset($this->connections[$connectionName])) {
            return $this->connections[$connectionName];
        }

        $parameters = $databaseConnections[$connectionName];

        $this->connections[$connectionName] = $this->pdoConnect($parameters);

        return $this->connections[$connectionName];
    }

    /**
     * @param $parameters
     *
     * @return PDO
     */
    public function pdoConnect($parameters)
    {
        list($server, $database, $username, $password) = [
            $parameters['server'],
            $parameters['database'],
            $parameters['username'],
            $parameters['password']
        ];

        try {
            $connection = new PDO(
                "mysql:host=$server;dbname=$database",
                $username,
                $password
            );

            // set the PDO error mode to exception
            $connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $connection;

        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}