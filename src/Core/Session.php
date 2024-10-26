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

    /**
     * @param string $key
     * @param mixed $message
     * @return void
     */
    public function setFlash(string $key, mixed $message): void
    {
       $_SESSION[self::FLASH_KEY][$key] = [
           'remove' => false,
           'value' => $message
       ];
    }

    /**
     * @param string $key
     * @return string
     */
    public function getFlash(string $key): string
    {
        return $_SESSION[self::FLASH_KEY][$key]['value']??false;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $_SESSION[$key]??false;
    }
    /**
     * @param string $key
     * @return void
     */
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
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