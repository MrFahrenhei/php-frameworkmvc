<?php
use App\Core\Form\Form;
use App\Models\User;

/**
 * @var User|null $model
 */
?>
    <h2>Login</h2>
<?php $form = Form::begin('', 'POST'); ?>
<?= $form->field($model, 'email')->emailField();?>
<?= $form->field($model, 'password')->passwordField();?>
    <hr class="my-4">
    <button type="submit" class="btn btn-outline-info">Login</button>
<?= Form::end(); ?>