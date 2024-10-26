<?php

namespace App\Core;

use App\Core\Exception\NotFoundException;

/**
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

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(
        public readonly Request $request,
        public readonly Response $response
    ){}

    /**
     * @param $path
     * @param $callback
     * @return void
     */
    public function get($path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * @param $path
     * @param $callback
     * @return void
     */
    public function post($path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @return mixed
     * @throws NotFoundException
     */
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
            return Application::$app->view->renderView($callback);
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
}