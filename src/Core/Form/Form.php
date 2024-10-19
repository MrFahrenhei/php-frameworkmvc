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
    public static function begin(string $action, string $method): Form
    {
       echo sprintf('<form class="needs-validation" action="%s" method="%s">', $action, $method);
       return new Form();
    }

    public static function end(): string
    {
       return '</form>';
    }

    public function field(Model $model, $attribute): Field
    {
       return new Field($model, $attribute);
    }
}