<?php

namespace App\Core;


use App\Core\DB\Database;
use App\Core\DB\DBModel;
use Exception;

/**
 * Class Application
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
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
    public View $view;
    public Session $session;
    public static Application $app;
    public ?Controller $controller = null;

    /**
     * @param string $rootPath
     * @param array $config
     */
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
        $this->view = new View();
        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if($primaryValue){
            $primaryKey = (new $this->userClass())->primaryKey();
            $this->user = (new $this->userClass())->findOne([$primaryKey=>$primaryValue]);
        }else{
            $this->user = null;
        }
    }

    /**
     * @return bool
     */
    public static function isGuest(): bool
    {
        return !self::$app->user;
    }

    /**
     * @return mixed
     */
    public function run(): mixed
    {
        try {
            return $this->router->resolve();
        }catch (Exception $e){
            $this->response->setStatusCode($e->getCode());
            return $this->view->renderView('_error', ['exception' => $e]);
        }
    }

    /**
     * @param DbModel $user
     * @return true
     */
    public function login(DbModel $user): true
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $this->user = null;
        $this->session->remove('user');
    }
}