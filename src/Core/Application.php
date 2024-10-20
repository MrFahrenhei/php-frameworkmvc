<?php

namespace App\Core;

/**
 * Class Application
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @param string $rootPath
 * @param array $config
 *@package App\Core
 */

class Application
{
    public static string $ROOT_DIR;
    public readonly Router $router;
    public readonly Request $request;
    public readonly Response $response;
    public readonly Database $db;
    public Session $session;
    public static Application $app;
    public Controller $controller;
    public function __construct(
        public readonly string $rootPath,
        public readonly array $config,
    )
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $this->db = new Database($config['db']);
    }

    public function run()
    {
        return $this->router->resolve();
    }
}