<?php
use App\Core\Form\Form;
use App\Core\Form\TextAreaField;
use App\Core\View;
use App\Models\ContactForm;

/**
 * @var $this View
 * @var $model ContactForm
 */

$this->title = 'Contact';
?>
<h2>Contact Us</h2>
    <?php $form = Form::begin('', 'POST'); ?>
    <?= $form->field($model, 'subject'); ?>
    <?= $form->field($model, 'email'); ?>
    <?= new TextAreaField($model, 'body'); ?>
    <hr class="my-4">
    <button type="submit" class="btn btn-primary">Submit</button>
    <?= Form::end(); ?>