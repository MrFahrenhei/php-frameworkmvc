<?php

namespace App\Core;
use App\Core\DB\DBModel;

/**
 * Class UserModel
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core
 */
abstract class UserModel extends DBModel
{
    abstract public function getDisplayName(): string;
}