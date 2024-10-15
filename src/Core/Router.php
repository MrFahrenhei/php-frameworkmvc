<?php

namespace App\Core;

/**
 * Class Router
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core
 */
class Router
{
    protected array $routes = [];

    public function __construct(public readonly Request $request)
    {
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if (!$callback) {
            return "Not found";
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        echo call_user_func($callback);
    }

    public function renderView($view)
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent()
    {
        ob_start();
        include_once Application::$ROOT_DIR . "/src/Views/layouts/main.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view){
        ob_start();
        include_once Application::$ROOT_DIR . "/src/Views/{$view}.php";
        return ob_get_clean();
    }

}