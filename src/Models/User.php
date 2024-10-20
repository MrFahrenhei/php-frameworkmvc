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
    private const STATUS_INACTIVE = 0;
    private const STATUS_ACTIVE = 1;
    private const STATUS_DELETED = 2;
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $confirmPassword = '';

    public function tableName(): string
    {
       return 'users';
    }
    public function save(): string
    {
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }
    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE,
                'class' => self::class,
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8, self::RULE_MAX, 'max'=>30]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match'=>'password']],
        ];
    }

    public function attributes(): array
    {
       return ['firstname', 'lastname', 'email', 'password', 'status'];
    }

    public function labels(): array
    {
        return [
            'firstname' => "First name",
            'lastname' => "Last name",
            'email' => "Email",
            'password' => "Password",
            'confirmPassword' => "Confirm Password",
            ];
    }
}