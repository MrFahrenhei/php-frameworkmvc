<?php

namespace App\Core;
/**
 * Class Controller
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core
 */
class Controller
{
    public string $layout = 'main';
    public function setLayout(string $layout): void
    {
       $this->layout = $layout;
    }
    public function render($view, $params = []): false|array|string
    {
        return Application::$app->router->renderView($view, $params);
    }
}