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
<h1>Contact Us</h1>
<div class="container">
    <?php $form = Form::begin('', 'POST'); ?>
    <?= $form->field($model, 'subject'); ?>
    <?= $form->field($model, 'email'); ?>
    <?= new TextAreaField($model, 'body'); ?>
    <hr class="my-4">
    <button type="submit" class="btn btn-primary">Submit</button>
    <?= Form::end(); ?>
</div>