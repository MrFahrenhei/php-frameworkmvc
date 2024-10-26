<?php

namespace App\Core\Form;
use App\Core\Model;

/**
 * Class BaseField
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core\Form
 */
abstract class BaseField
{
    /**
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(
        public readonly Model $model,
        public readonly string $attribute,
    )
    {
    }
    abstract public function renderInput(): string;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            '<div class="form-group">
                        <label for="subject" class="form-label mt-4">%s</label>
                        %s
                       <div class="invalid-feedback">%s</div> 
                    </div>',
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute),
        );
    }
}