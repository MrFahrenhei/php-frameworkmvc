<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if($request->isPost()) {
            return 'Handle submited data login post';
        }
       return $this->render('login');
    }

    public function register(Request $request)
    {
        if($request->isPost()) {
            return 'Handle submited data register post';
        }
       return $this->render('register');
    }
}