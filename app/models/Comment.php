<?php

namespace app\models;

use core\AbstractModel;

/**
 * Comment Model
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class Comment extends AbstractModel
{
    /**
     * Database table name
     */
    const TABLE_NAME = 'comments';

    /**
     * Return comments by post id
     *
     * @param int $postId Post id
     *
     * @return array
     */
    public function getByPostId($postId)
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getSelectQuery());
        $statement->bindValue(':post_id', $postId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Save comment
     *
     * @param int    $postId   Post id
     * @param string $body     Body
     * @param string $username Username
     *
     * @return void
     */
    public function save($postId, $body, $username)
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getInsertQuery());
        $statement->bindValue(':post_id', $postId, \PDO::PARAM_INT);
        $statement->bindValue(':body', $body, \PDO::PARAM_STR);
        $statement->bindValue(':username', $username, \PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * Return select query
     *
     * @return string
     */
    private function getSelectQuery()
    {
        return \sprintf(
            'SELECT * FROM %s WHERE post_id = :post_id',
            self::TABLE_NAME
        );
    }

    /**
     * Return insert query
     *
     * @return string
     */
    private function getInsertQuery()
    {
        return \sprintf(
            'INSERT INTO %s (post_id, body, username) VALUES (:post_id, :body, :username)',
            self::TABLE_NAME
        );
    }
}