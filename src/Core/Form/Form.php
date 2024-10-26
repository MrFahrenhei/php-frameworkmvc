<?php

namespace App\Core\Form;

use App\Core\Model;

/**
 * Class Form
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core\Form
 */
class Form
{
    /**
     * @param string $action
     * @param string $method
     * @return Form
     */
    public static function begin(string $action, string $method): Form
    {
       echo sprintf('<form class="needs-validation" action="%s" method="%s">', $action, $method);
       return new Form();
    }

    /**
     * @return string
     */
    public static function end(): string
    {
       return '</form>';
    }

    /**
     * @param Model $model
     * @param $attribute
     * @return InputField
     */
    public function field(Model $model, $attribute): InputField
    {
       return new InputField($model, $attribute);
    }
}