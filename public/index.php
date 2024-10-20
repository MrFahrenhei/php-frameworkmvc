<?php
require_once dirname(__DIR__,1) . '/vendor/autoload.php';
$routes = require_once dirname(__DIR__,1) . '/config/routes.php';

use App\Core\Application;

(Dotenv\Dotenv::createImmutable(dirname(__DIR__,1)))->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];
$app = new Application(dirname(__DIR__, 1), $config);
foreach ($routes as $method => $route){
    if($method == 'get'){
        foreach($route as $key=>$value){
            $app->router->get($key, $value);
        }
    }else if($method == 'post'){
        foreach($route as $key=>$value){
            $app->router->post($key, $value);
        }
    }
}
//$app->router->get('/', 'home');
//$app->router->get('/contact', [SiteController::class, 'contact']);
//$app->router->post('/contact', [SiteController::class, 'handleContact']);
echo $app->run();