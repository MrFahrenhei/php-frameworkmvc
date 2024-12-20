<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\LoginForm;
use App\Models\User;

/**
 * Class AuthController
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Controllers
 */
class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return false|array|string
     */
    public function login(Request $request, Response $response): false|array|string
    {
        $loginForm = new LoginForm();
        if($request->isPost()){
            $loginForm->loadData($request->getBody());
            if($loginForm->validate() && $loginForm->login()){
                $response->redirect('/');
            }
        }
        $this->setLayout('auth');
        return $this->render('login', ['model'=>$loginForm]);
    }

    /**
     * @param Request $request
     * @return false|array|string
     */
    public function register(Request $request): false|array|string
    {
        $user = new User();
        if($request->isPost()) {
            $user->loadData($request->getBody());
            if($user->validate() && $user->save()){
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/');
            }
            return $this->render('register', ['model' => $user]);
        }
        $this->setLayout('auth');
        return $this->render('register', ['model'=>$user]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function logout(Request $request, Response $response): void
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    /**
     * @return false|array|string
     */
    public function profile(): false|array|string
    {
        return $this->render('profile');
    }
}