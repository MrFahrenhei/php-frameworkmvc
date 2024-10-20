<?php

namespace App\Core\Form;
use App\Core\Model;

/**
 * Class Field
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core\Form
 */
class Field
{
    public const string TYPE_TEXT = 'text';
    public const string TYPE_PASSWORD = 'password';
    public const string TYPE_NUMBER = 'number';
    public const string TYPE_EMAIL = 'email';
    public function __construct(
        public readonly Model $model,
        public readonly string $attribute,
        public string $type = self::TYPE_TEXT,
    )
    {
    }
    public function __toString(): string
    {
        return sprintf(
            '<div class="form-group">
                        <label for="subject" class="form-label">%s</label>
                        <input type="%s"  name="%s" placeholder="" value="%s" class="form-control%s">
                       <div class="invalid-feedback">%s</div> 
                    </div>',
            $this->attribute,
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute)? ' is-invalid' : '',
            $this->model->getFirstError($this->attribute)
        );
    }

    public function passwordField(): static
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
    public function emailField(): static
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }
}