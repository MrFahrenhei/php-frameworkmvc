<?php

namespace App\Controllers;
use App\Core\Application;

/**
 * Class SiteController
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Controllers
 */
class SiteController
{
    public function home(): string
    {
        $params = [
            'name' => "beraldo"
        ];
        return Application::$app->router->renderView('home', $params);
    }
    public function handleContact(): string
    {
       return 'Handling submitted data';
    }
}