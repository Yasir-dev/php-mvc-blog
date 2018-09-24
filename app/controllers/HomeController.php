<?php

namespace app\controllers;

use core\AbstractController;
use core\View;
use app\models\PostModel;

/**
 * HomeController Controller
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class HomeController extends AbstractController
{
    /**
     * Show index page
     *
     * @return void
     */
    public function indexAction()
    {
        $posts = (new PostModel())->getAll();

        View::renderTemplate(
            'index.html',
            array('posts' => $posts, 'is_logged' => $this->session->get('login'), 'name' =>  $this->session->get('username'))
        );
    }
}