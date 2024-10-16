<?php

namespace App\Core;

/**
 * Class Router
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core
 * @param App\core\Request $request
 * @param App\core\Response $response
 */
class Router
{
    protected array $routes = [];
    public function __construct(
        public readonly Request $request,
        public readonly Response $response
    ){}
    public function get($path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }
    public function post($path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }
    public function resolve(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if (!$callback) {
            $this->response->setStatusCode(404);
            return $this->renderView('_404');
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            $controller = new $callback[0]();
            return call_user_func([$controller, $callback[1]]);
        }
        return call_user_func($callback);
    }
    public function renderView($view, $params = []): array|false|string
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
    protected function renderContent(string $viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
    protected function layoutContent(): false|string
    {
        ob_start();
        include_once Application::$ROOT_DIR . "/src/Views/layouts/main.php";
        return ob_get_clean();
    }
    protected function renderOnlyView(string $view, array $params): false|string
    {
        foreach($params as $key => $value) {
            $$key  = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/src/Views/{$view}.php";
        return ob_get_clean();
    }
}