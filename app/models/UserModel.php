<?php

namespace app\models;

use core\AbstractModel;

/**
 * User Model
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class UserModel extends AbstractModel
{
    /**
     * posts table
     */
    const TABLE_NAME = 'users';

    /**
     * Login user
     *
     * @param string $username Username
     *
     * @return mixed
     */
    public function login(string $username)
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getSelectQuery());
        $statement->bindValue(':username', $username, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * Register user
     *
     * @param string $username Username
     * @param string $password Password
     *
     * @return void
     */
    public function register(string $username, string $password)
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getInsertQuery());
        $statement->bindValue(':username', $username, \PDO::PARAM_STR);
        $statement->bindValue(':password', $password, \PDO::PARAM_STR);

        $statement->execute();
    }

    /**
     * Return select query
     *
     * @return string
     */
    private function getSelectQuery(): string
    {
        return \sprintf(
            'SELECT username, password FROM %s WHERE username = :username',
            self::TABLE_NAME
        );
    }

    /**
     * Return insert query
     *
     * @return string
     */
    private function getInsertQuery(): string
    {
        return \sprintf(
            'INSERT INTO %s (username, password) VALUES (:username, :password)',
            self::TABLE_NAME
        );
    }
}
