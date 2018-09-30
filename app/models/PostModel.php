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
class PostModel extends AbstractModel
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
    public function getAll(): array
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
    public function getById(int $id): array
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getSelectByIdQuery());
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * Return posts by user
     *
     * @param string $userName UserModel name
     *
     * @return array
     */
    public function getByUser(string $userName): array
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getSelectByUserQuery());
        $statement->bindValue(':username', $userName, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Save post
     *
     * @param string $title    Title
     * @param string $body     Body
     * @param string $username Username
     *
     * @return void
     */
    public function save(string $title, string $body, string $username)
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getInsertQuery());
        $statement->bindValue(':title', $title, \PDO::PARAM_STR);
        $statement->bindValue(':body', $body, \PDO::PARAM_STR);
        $statement->bindValue(':username', $username, \PDO::PARAM_STR);

        $statement->execute();
    }

    /**
     * Update post
     *
     * @param int    $postId Post id
     * @param string $title  Title
     * @param string $body   Body
     *
     * @return void
     */
    public function update(int $postId, string $title, string $body)
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getUpdateQuery());
        $statement->bindValue(':title', $title, \PDO::PARAM_STR);
        $statement->bindValue(':body', $body, \PDO::PARAM_STR);
        $statement->bindValue(':id', $postId, \PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * Delete post
     *
     * @param int $postId PostController Id
     */
    public function delete(int $postId)
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
    private function getSelectAllQuery(): string
    {
        return \sprintf(
            'SELECT * FROM %s ORDER BY created_at DESC',
            self::TABLE_NAME
        );
    }

    /**
     * Return select by id query
     *
     * @return string
     */
    private function getSelectByIdQuery(): string
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
    private function getSelectByUserQuery(): string
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
    private function getInsertQuery(): string
    {
        return \sprintf(
            "INSERT INTO %s (title, body, username) VALUES (:title, :body, :username)",
            self::TABLE_NAME
        );
    }

    /**
     * Return update query
     *
     * @return string
     */
    private function getUpdateQuery(): string
    {
        return \sprintf(
            "UPDATE %s SET title = :title, body = :body WHERE id = :id",
            self::TABLE_NAME
        );
    }

    /**
     * Return delete query
     *
     * @return string
     */
    private function getDeleteByIdQuery(): string
    {
        return \sprintf(
            'DELETE FROM %s WHERE id = :id',
            self::TABLE_NAME
        );
    }
}
