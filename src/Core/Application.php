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
    public function __construct(public readonly string $rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}