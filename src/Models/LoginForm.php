<?php

namespace App\Models;
use App\Core\Application;
use App\Core\Model;

/**
 * Class LoginForm
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Models
 */
class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';
    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array
    {
       return [
           'email' => 'Your Email',
           'password' => 'Password',
       ];
    }

    public function login(): bool
    {
        $user = (new User())->findOne(['email' => $this->email]);
        if(!$user){
           $this->addError('email', 'User does not exist with this email');
           return false;
        }
        if(!password_verify($this->password, $user->password)){
            $this->addError('password', 'Password is incorrect');
            return false;
        }
        return Application::$app->login($user);
    }
}