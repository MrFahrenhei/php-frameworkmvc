<?php
require_once dirname(__DIR__,1) . '/vendor/autoload.php';
$routes = require_once dirname(__DIR__,1) . '/config/routes.php';
use App\Core\Application;
$app = new Application(dirname(__DIR__, 1));
foreach ($routes as $method => $route){
    if($method == 'get'){
        foreach($route as $key=>$value){
            $app->router->get($key, $value);
        }
    }
}
$app->run();

// 52:47
// https://www.youtube.com/watch?v=6ERdu4k62wI&list=WL