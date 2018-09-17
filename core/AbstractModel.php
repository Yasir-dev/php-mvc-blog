<?php

namespace core;

use app\AppConfig;

/**
 * Abstract modal class (This class handle the DB connection)
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
abstract class AbstractModel
{
    /**
     * PDO driver
     *
     * @var \PDO
     */
    private $connection = null;

    /**
     * Return PDO connection
     *
     * @return \PDO
     */
    protected function getDatabaseConnection()
    {
        if (null === $this->connection) {
            $this->connection = new \PDO($this->getDsn(), AppConfig::DB_USERNAME, AppConfig::DB_PASSWORD);
            //set attribute so PDO throw exception when error occurs
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return $this->connection;
    }

    /**
     * Return data source name string
     *
     * @return string
     */
    private function getDsn()
    {
        return \sprintf(
            'mysql:host=%s;dbname=%s;charset=utf8',
            AppConfig::DB_HOST,
            AppConfig::DB_NAME
        );
    }
}
