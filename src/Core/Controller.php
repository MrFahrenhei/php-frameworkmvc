<?php

namespace App\Core;
use App\Core\Middlewares\BaseMiddleware;

/**
 * Class Controller
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core
 */
class Controller
{
    public string $layout = 'main';
    public string $action = '';
    /**
     * @var BaseMiddleware[]
     */
    protected array $middleware = [];
    public function setLayout(string $layout): void
    {
       $this->layout = $layout;
    }
    public function render($view, $params = []): false|array|string
    {
        return Application::$app->router->renderView($view, $params);
    }
    public function registerMiddleware(BaseMiddleware $middleware): void
    {
        $this->middleware[] = $middleware;
    }
    public function getMiddleware(): array
    {
        return $this->middleware;
    }
}