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

    /**
     * @param string $layout
     * @return void
     */
    public function setLayout(string $layout): void
    {
       $this->layout = $layout;
    }

    /**
     * @param string $view
     * @param array $params
     * @return false|array|string
     */
    public function render(string $view, array $params = []): false|array|string
    {
        return Application::$app->view->renderView($view, $params);
    }

    /**
     * @param BaseMiddleware $middleware
     * @return void
     */
    public function registerMiddleware(BaseMiddleware $middleware): void
    {
        $this->middleware[] = $middleware;
    }

    /**
     * @return BaseMiddleware[]
     */
    public function getMiddleware(): array
    {
        return $this->middleware;
    }
}