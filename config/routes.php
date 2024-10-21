<?php

use App\Controllers\AuthController;
use App\Controllers\SiteController;

return [
    'get'=>[
        "/" => [SiteController::class, "home"],
        "/func" => function(){ return 'hello'; },
        "/contact" => [SiteController::class, "contact"],
        "/register" => [AuthController::class, "register"],
        "/login" => [AuthController::class, "login"],
        "/logout"=> [AuthController::class, "logout"],
        "/profile"=> [AuthController::class, "profile"],
    ],
    'post'=>[
        "/" => 'home',
        "/users" => 'contact',
        "/contact" => [SiteController::class, "handleContact"],
        "/login" => [AuthController::class, "login"],
        "/register" => [AuthController::class, "register"],
    ],
];