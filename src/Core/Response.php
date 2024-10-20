<?php

namespace App\Core;

/**
 * Class Response
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core
 */

class Response
{
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }
}