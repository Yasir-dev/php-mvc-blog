<?php

namespace app\controllers;

use app\models\CommentModel;
use app\models\PostModel;
use app\RedirectLocation;
use app\Request;
use core\AbstractController;
use core\View;

/**
 * Post Controller
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class PostController extends AbstractController
{
    /**
     * Show index page
     *
     * @return void
     */
    public function showAction()
    {
        $postId = $this->getId();
        $post = (new PostModel())->getById($postId);
        $comments = (new CommentModel())->getByPostId($postId);

        View::renderTemplate(
            'post/post.html',
            array(
                'post' => $post,
                'comments' => $comments,
                'total_comments' => \sizeof($comments),
                'is_logged' => $this->session->get('login'),
                'name' =>  $this->session->get('username')
            )
        );
    }

    /**
     * Show posts of a user
     *
     * @return void
     */
    public function userAction()
    {
        $posts = (new PostModel())->getByUser(Request::get('name', false, Request::METHOD_GET));

        View::renderTemplate(
            'post/user_posts.html',
            array(
                'posts' => $posts,
                'is_logged' => $this->session->get('login'),
                'name' =>  $this->session->get('username')
            )
        );
    }

    /**
     * User User comments
     *
     * @return void
     */
    public function userCommentAction()
    {
        $comments = (new CommentModel())->getByUser(Request::get('name', false, Request::METHOD_GET));

        View::renderTemplate(
            'post/user_comments.html',
            array(
                'comments' => $comments,
                'is_logged' => $this->session->get('login'),
                'name' =>  $this->session->get('username')
            )
        );
    }

    /**
     * Add post action
     *
     * @return void
     */
    public function addAction()
    {
        $isLoggedIn = $this->session->get('login');

        if ($isLoggedIn) {
            View::renderTemplate(
                'post/add_post.html',
                array(
                    'is_logged' => $isLoggedIn,
                    'name' =>  $this->session->get('username')
                ));
            return;
        }

        RedirectLocation::redirect('/');
    }

    /**
     * Save post action
     *
     * @return void
     */
    public function saveAction()
    {
        (new PostModel())->save(
            Request::get('title', true),
            Request::get('body', true),
            $this->session->get('username')
        );

        RedirectLocation::redirect('/');
    }

    /**
     * Add comment action
     *
     * @return void
     */
    public function addCommentAction()
    {
        if ($this->session->get('login')) {
            View::renderTemplate('post/add_comment.html');
            return;
        }

        RedirectLocation::redirect('/');
    }

    /**
     * Save comment action
     *
     * @return void
     */
    public function saveCommentAction()
    {
        $postId  = Request::get('postId');
        $body  = Request::get('body', true);
        $userName = $this->session->get('username');

        (new CommentModel())->save($postId, $body, $userName);
        RedirectLocation::redirect('/post/'.$postId.'/show');
    }

    /**
     * Delete post action
     *
     * @return void
     */
    public function deleteAction()
    {
        $postId = $this->getId();

        (new PostModel())->delete($postId);
        (new CommentModel())->deleteByPostId($postId);

        RedirectLocation::redirect('/');
    }

    /**
     * Edit action
     *
     * @return void
     */
    public function editAction()
    {
        $post = (new PostModel())->getById($this->getId());
        $isLoggedIn = $this->session->get('login');

        if ($isLoggedIn) {
            View::renderTemplate(
                'post/add_post.html',
                array(
                    'is_logged' => $isLoggedIn,
                    'name' =>  $this->session->get('username'),
                    'edit' => true,
                    'post' => $post
                )
            );
            return;
        }

        RedirectLocation::redirect('/');
    }

    /**
     * Edit post action
     *
     * @return void
     */
    public function editPostAction()
    {
        (new PostModel())->update($this->getId(), Request::get('title', true), Request::get('body', true));
        RedirectLocation::redirect('/post/'.$this->getId().'/show');
    }

    /**
     * Delete post comment
     *
     * @return void
     */
    public function deleteCommentAction()
    {
        $postId = Request::get('postId', false, Request::METHOD_GET);
        (new CommentModel())->deleteById($this->getId());

        RedirectLocation::redirect('/post/'.$postId.'/show');
    }

    /**
     * Return id
     *
     * @return int
     */
    private function getId(): int
    {
        return $this->routeParameters['id'];
    }
}
