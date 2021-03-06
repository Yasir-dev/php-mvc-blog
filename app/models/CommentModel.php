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
class CommentModel extends AbstractModel
{
    /**
     * Database table name
     */
    const TABLE_NAME = 'comments';

    /**
     * Return comments by post id
     *
     * @param int $postId PostController id
     *
     * @return array
     */
    public function getByPostId(int $postId): array
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getSelectQuery());
        $statement->bindValue(':post_id', $postId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Return comments by user name
     *
     * @param string $userName User name
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
     * Save comment
     *
     * @param int    $postId   PostController id
     * @param string $body     Body
     * @param string $username Username
     *
     * @return void
     */
    public function save(int $postId, string $body, string $username)
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getInsertQuery());
        $statement->bindValue(':post_id', $postId, \PDO::PARAM_INT);
        $statement->bindValue(':body', $body, \PDO::PARAM_STR);
        $statement->bindValue(':username', $username, \PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * Delete comments for a post
     *
     * @param int $postId
     */
    public function deleteByPostId(int $postId)
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getDeletePostByIdQuery());
        $statement->bindValue(':post_id', $postId, \PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Delete a comment
     *
     * @param int $commentId CommentModel Id
     */
    public function deleteById(int $commentId)
    {
        $statement = $this->getDatabaseConnection()->prepare($this->getDeleteByIdQuery());
        $statement->bindValue(':id', $commentId, \PDO::PARAM_INT);
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
            'SELECT * FROM %s WHERE post_id = :post_id',
            self::TABLE_NAME
        );
    }

    /**
     * Return select query
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
            'INSERT INTO %s (post_id, body, username) VALUES (:post_id, :body, :username)',
            self::TABLE_NAME
        );
    }

    /**
     * Return delete query
     *
     * @return string
     */
    private function getDeletePostByIdQuery(): string
    {
        return \sprintf(
            'DELETE FROM %s WHERE post_id = :post_id',
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
