<?php

namespace app\controllers;

use app\AppConfig;
use app\models\UserModel;
use app\RedirectLocation;
use app\Request;
use core\AbstractController;
use core\View;

/**
 * UserModel AuthenticationController controller
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class AuthenticationController extends AbstractController
{
    /**
     * Show login view
     */
    public function loginAction()
    {
        View::renderTemplate('user/login.html');
    }

    /**
     * PostController login action
     */
    public function loginPostAction()
    {
        $request = (new Request());
        $userName = $request->get('username');
        $password = $request->get('password');

        if ('' === $userName || '' === $password ) {
            RedirectLocation::redirect('/authentication/login');
            return;
        }

        $user = (new UserModel())->login($userName);

        if (true === (bool) $user && true === $this->verifyPassword($password, $user['password'])) {
            $this->session->set('login', true)->set('username', $userName);
            RedirectLocation::redirect('/');
            return;
        }

        RedirectLocation::redirect('/authentication/login');
    }

    /**
     * Show register view
     */
    public function registerAction()
    {
        View::renderTemplate('user/register.html');
    }

    /**
     * PostController register action
     */
    public function registerPostAction()
    {
        $request = (new Request());

        $userName = $request->get('username');
        $password = $request->get('password');
        $passwordMatch = $request->get('password_match');

        if ('' === $userName || '' === $password || $password !== $passwordMatch) {
            RedirectLocation::redirect('/authentication/register');
            return;
        }

        (new UserModel())->register($userName, $this->getHashedPassword($password));
        RedirectLocation::redirect('/authentication/login');
    }

    /**
     * Logout action
     */
    public function logoutAction()
    {
        $this->session->destroy();
        RedirectLocation::redirect('/');
    }

    /**
     * Return hashed password
     *
     * @param string $password
     *
     * @return bool|string
     */
    private function getHashedPassword($password)
    {
        return \password_hash(AppConfig::USER_PASSWORD_SALT.$password, PASSWORD_BCRYPT);
    }

    /**
     * Verify user password
     *
     * @param string $password Password
     * @param string $hash Hash of password
     *
     * @return bool
     */
    private function verifyPassword($password, $hash)
    {
        return \password_verify(AppConfig::USER_PASSWORD_SALT.$password, $hash);
    }
}