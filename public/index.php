<?php
require_once dirname(__DIR__,1) . '/vendor/autoload.php';
$routes = require_once dirname(__DIR__,1) . '/config/routes.php';

use App\Controllers\SiteController;
use App\Core\Application;
$app = new Application(dirname(__DIR__, 1));
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