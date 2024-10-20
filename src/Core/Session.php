<?php

namespace App\Core;
/**
 * Class Session
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core
 */
class Session
{
    protected const FLASH_KEY = '__flash';
    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach($flashMessages as $key => &$message) {
           $message['remove'] = true;

        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function setFlash(string $key, mixed $message): void
    {
       $_SESSION[self::FLASH_KEY][$key] = [
           'remove' => false,
           'value' => $message
       ];
    }

    public function getFlash(string $key): string
    {
        return $_SESSION[self::FLASH_KEY][$key]['value']??false;
    }
    public function __destruct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach($flashMessages as $key => &$message) {
            if($message['remove']){
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}