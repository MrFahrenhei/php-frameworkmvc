<?php
use App\Core\Form\Form;
use App\Models\User;

/**
 * @var User|null $model
 */
?>
<div class="container">
    <h1>Login</h1>
        <?php $form = Form::begin('', 'POST'); ?>
        <div class="row">
            <div class="col">
                <?= $form->field($model, 'email')->emailField();?>
            </div>
            <div class="col">
                <?= $form->field($model, 'password')->passwordField();?>
            </div>
            <hr class="my-4">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    <?= Form::end(); ?>
</div>