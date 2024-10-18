<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\RegisterModel;

/**
 * Class AuthController
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Controllers
 */
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request)
    {
        if($request->isPost()) {
            $registerModel = new RegisterModel();
            $registerModel->loadData($request->getBody());

            if($registerModel->validate() && $registerModel->register()){
                return 'Success';
            }
            echo '<pre>';
            var_dump($registerModel->errors);
            echo '</pre>';
            exit();
            return $this->render('register', [
                'model' => $registerModel,
            ]);
        }
        $this->setLayout('auth');
        return $this->render('register', [
            'model'=>$registerModel,
        ]);
    }
}