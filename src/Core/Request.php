<?php

namespace App\Core;

/**
 * Class Request
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core
 */
class Request
{
    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if(!$position){
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}