<?php

use App\Controllers\AuthController;
use App\Controllers\SiteController;

return [
    'get'=>[
        "/" => [SiteController::class, "home"],
        "/contact" => [SiteController::class, "contact"],
        "/func" => function(){ return 'hello'; },
        "/login" => [AuthController::class, "login"],
        "/register" => [AuthController::class, "register"],
    ],
    'post'=>[
        "/" => 'home',
        "/users" => 'contact',
        "/contact" => [SiteController::class, "handleContact"],
        "/login" => [AuthController::class, "login"],
        "/register" => [AuthController::class, "register"],
    ],
];