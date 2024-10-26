<?php

namespace App\Core;

use App\Core\Exception\NotFoundException;/**
 * Class Router
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @param Request $request
 * @param Response $response
 *@package App\Core
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
            //$this->response->setStatusCode(404);
            //return $this->renderView('_404');
            throw new NotFoundException();
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            /** @var Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;
            foreach($controller->getMiddleware() as $middleware) {
                $middleware->execute();
            }
        }
        return call_user_func($callback, $this->request, $this->response);
    }
    public function renderView($view, $params = []): array|false|string
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
    protected function renderContent(string $viewContent): array|false|string
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
    protected function layoutContent(): false|string
    {
        $layout = Application::$app->layout;
        if(Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
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