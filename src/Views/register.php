<?php

use App\Core\Form\Form;
use App\Models\User;

/**
 * @var User|null $model
 */
?>
    <h1>Create an account</h1>
<?php $form = Form::begin('', 'POST'); ?>
    <div class="row">
        <div class="col">
            <?= $form->field($model, 'firstname'); ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'lastname') ?>
        </div>
    </div>
<?= $form->field($model, 'email')->emailField(); ?>
<?= $form->field($model, 'password')->passwordField(); ?>
<?= $form->field($model, 'confirmPassword')->passwordField(); ?>
    <hr class="my-4">
    <button type="submit" class="btn btn-outline-info">Submit</button>
<?php echo Form::end(); ?>