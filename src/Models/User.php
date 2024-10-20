<?php

namespace App\Models;

use App\Core\DBModel;
use App\Core\Model;

/**
 * Class RegisterModel
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Models
 */

class User extends DBModel
{
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';

    public function register(): string
    {
       return 'Creating new User';
    }
    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8, self::RULE_MAX, 'max'=>30]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match'=>'password']],
        ];
    }
}