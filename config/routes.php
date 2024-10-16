<?php

use App\Controllers\SiteController;

return [
    'get'=>[
        "/" => [SiteController::class, "home"],
        "/contact" => [SiteController::class, "contact"],
        "/func" => function(){ return 'hello'; }
    ],
    'post'=>[
        "/" => 'home',
        "/users" => 'contact',
        "/contact" => [SiteController::class, "handleContact"]
    ]
];