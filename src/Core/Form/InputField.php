<?php

namespace App\Core\Form;
use App\Core\Model;

/**
 * Class Field
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core\Form
 */
class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_EMAIL = 'email';
    public string $type;

    /**
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(
        Model $model,
        string $attribute,
    )
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }

    /**
     * @return $this
     */
    public function passwordField(): static
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    /**
     * @return $this
     */
    public function emailField(): static
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    /**
     * @return string
     */
    public function renderInput(): string
    {
        return sprintf(
            '<input type="%s"  name="%s" placeholder="" value="%s" class="form-control%s">',
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute)? ' is-invalid' : '',
        );
    }
}