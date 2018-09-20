<?php

namespace app\models;

use core\AbstractModel;

/**
 * Post Model
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class Post extends AbstractModel
{
    /**
     * posts table
     */
    const TABLE_NAME = 'posts';

    /**
     * Return all posts
     *
     * @return array
     */
    public function getAll()
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getSelectAllQuery());
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Return post by ids
     *
     * @param int $id Id
     *
     * @return array
     */
    public function getById($id)
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getSelectByIdQuery());
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * Return posts by user
     *
     * @param string $userName User name
     *
     * @return array
     */
    public function getByUser($userName)
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getSelectByUserQuery());
        $statement->bindValue(':username', $userName, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Save Post
     *
     * @param string $title    Title
     * @param string $body     Body
     * @param string $username Username
     *
     * @return void
     */
    public function save($title, $body, $username)
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getInsertQuery());
        $statement->bindValue(':title', $title, \PDO::PARAM_STR);
        $statement->bindValue(':body', $body, \PDO::PARAM_STR);
        $statement->bindValue(':username', $username, \PDO::PARAM_STR);

        $statement->execute();
    }

    /**
     * Delete post
     *
     * @param int $postId Post Id
     */
    public function delete($postId)
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getDeleteByIdQuery());
        $statement->bindValue(':id', $postId, \PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Return select all query
     *
     * @return string
     */
    private function getSelectAllQuery()
    {
        return \sprintf(
            'SELECT * FROM %s',
            self::TABLE_NAME
        );
    }

    /**
     * Return select by id query
     *
     * @return string
     */
    private function getSelectByIdQuery()
    {
        return \sprintf(
            'SELECT * FROM %s WHERE id = :id',
            self::TABLE_NAME
        );
    }

    /**
     * Return select by id query
     *
     * @return string
     */
    private function getSelectByUserQuery()
    {
        return \sprintf(
            'SELECT * FROM %s WHERE username = :username',
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
            "INSERT INTO %s (title, body, username) VALUES (:title, :body, :username)",
            self::TABLE_NAME
        );
    }

    /**
     * Return delete query
     *
     * @return string
     */
    private function getDeleteByIdQuery()
    {
        return \sprintf(
            'DELETE FROM %s WHERE id = :id',
            self::TABLE_NAME
        );
    }
}
