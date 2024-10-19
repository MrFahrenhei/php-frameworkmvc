<?php

namespace App\Controllers;
use App\Core\Application;
use App\Core\Controller;
use App\Core\Request;

/**
 * Class SiteController
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Controllers
 */
class SiteController extends Controller
{
    public function home(): string
    {
        $params = [
            'name' => "beraldo",
            'pipoca' => "eu gosto",
            'ola' => 'não deixa'
        ];
        return $this->render('home', $params);
    }

    public function handleContact(Request $request)
    {
        $body = $request->getBody();
    }
    public function contact(): string
    {
        return $this->render('contact');
    }
}