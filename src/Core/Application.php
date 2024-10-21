<?php

namespace App\Core;

use App\Models\User;

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
    public string $userClass;
    public string $layout = 'main';
    public readonly Router $router;
    public readonly Request $request;
    public readonly Response $response;
    public readonly Database $db;
    public ?DbModel $user;
    public Session $session;
    public static Application $app;
    public ?Controller $controller = null;
    public function __construct(
        public readonly string $rootPath,
        public readonly array $config,
    )
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if($primaryValue){
            $primaryKey = (new $this->userClass())->primaryKey();
            $this->user = (new $this->userClass())->findOne([$primaryKey=>$primaryValue]);
        }else{
            $this->user = null;
        }
    }

    public static function isGuest(): bool
    {
        return !self::$app->user;
    }

    public function run()
    {
        return $this->router->resolve();
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }
}