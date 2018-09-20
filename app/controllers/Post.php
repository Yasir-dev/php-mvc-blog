<?php

namespace app\controllers;

use app\models\Comment;
use app\RedirectLocation;
use app\Request;
use core\AbstractController;
use core\View;

/**
 * Post controller
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class Post extends AbstractController
{
    /**
     * Show index page
     *
     * @return void
     */
    public function showAction()
    {
        $postId = $this->routeParameters['id'];
        $post = (new \app\models\Post())->getById($postId);
        $comments = (new Comment())->getByPostId($postId);

        View::renderTemplate(
            'post/post.html',
            array('post' => $post, 'comments' => $comments,'is_logged' => $this->session->get('login'), 'name' =>  $this->session->get('username') )
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
                array('is_logged' => $isLoggedIn, 'name' =>  $this->session->get('username')));
            return;
        }

        RedirectLocation::redirect('/');

    }

    /**
     * Save post action
     */
    public function saveAction()
    {
        $request = (new Request());
        $title = $request->get('title', true);
        $body  = $request->get('body', true);
        $userName = $this->session->get('username');

        (new \app\models\Post())->save($title, $body, $userName);
        RedirectLocation::redirect('/');

    }

    /**
     * Add comment action
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
     */
    public function saveCommentAction()
    {
        $request = (new Request());
        $postId  = $request->get('postId');
        $body  = $request->get('body', true);
        $userName = $this->session->get('username');

        (new Comment())->save($postId, $body, $userName);
        RedirectLocation::redirect('/post/'.$postId.'/show');
    }

    /**
     * Delete post action
     */
    public function deleteAction()
    {
        $postId = $this->routeParameters['id'];

        (new \app\models\Post())->delete($postId);
        (new Comment())->deleteByPostId($postId);

        RedirectLocation::redirect('/');
    }

    public function deleteCommentAction()
    {
        $postId = (new Request())->get('postId', false, Request::METHOD_GET);

        $commentId = $this->routeParameters['id'];

        (new Comment())->deleteById($commentId);

        RedirectLocation::redirect('/post/'.$postId.'/show');
    }
}
