<?php

namespace App\Core\Middlewares;
/**
 * Class BaseMiddleware
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core\Middlewares
 */
abstract class BaseMiddleware
{
    abstract public function execute();
}