<?php

namespace App\Core\Exception;
/**
 * Class ForbiddenException
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core\Exception
 *
 */
class ForbiddenException extends \Exception
{
    protected $code = 403;
    protected $message = 'You don\'t have permission to access this page.';
}