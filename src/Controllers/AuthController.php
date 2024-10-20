<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\Request;
use App\Models\User;

/**
 * Class AuthController
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Controllers
 */
class AuthController extends Controller
{
    public function login(): false|array|string
    {
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request): false|array|string
    {

        $user = new User();
        if($request->isPost()) {
            $user->loadData($request->getBody());
            if($user->validate() && $user->save()){
                Application::$app->response->redirect('/');
            }
            return $this->render('register', [
                'model' => $user,
            ]);
        }
        $this->setLayout('auth');
        return $this->render('register', [
            'model'=>$user,
        ]);
    }
}