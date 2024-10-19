<?php

namespace App\Core;

/**
 * Class Router
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core
 * @param Request $request
 * @param Response $response
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
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if (!$callback) {
            $this->response->setStatusCode(404);
            return $this->renderView('_404');
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }
        return call_user_func($callback, $this->request);
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
        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR . "/src/Views/layouts/{$layout}.php";
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