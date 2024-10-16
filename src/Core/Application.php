<?php

namespace App\Core;

/**
 * Class Application
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core
 */

class Application
{
    public static string $ROOT_DIR;
    public readonly Router $router;
    public readonly Request $request;
    public readonly Response $response;
    public static Application $app;
    public function __construct(public readonly string $rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        return $this->router->resolve();
    }
}