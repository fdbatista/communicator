<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CreateUserForm */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'user_name', [
                'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>{input}</div>',
            ])
                ->textInput([
                    'autofocus' => true,
                    'maxlength' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Nombre de usuario',
                ])
                ->label(false) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'full_name', [
                'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-text-width"></i></span>{input}</div>',
            ])
                ->textInput([
                    'maxlength' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Nombre completo',
                ])
                ->label(false) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'mobile_number', [
                'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>{input}</div>',
            ])
                ->textInput([
                    'maxlength' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Teléfono',
                ])
                ->label(false) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'email', [
                'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>{input}</div>',
            ])
                ->textInput([
                    'maxlength' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Email',
                ])
                ->label(false) ?>
        </div>
    </div>

    <?php if ($model->isNewRecord) { ?>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'password', [
                    'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>{input}</div>',
                ])
                    ->passwordInput([
                        'maxlength' => true,
                        'class' => 'form-control',
                        'placeholder' => 'Contraseña',
                    ])
                    ->label(false) ?>
            </div>

            <div class="col-md-4">
                <?= $form->field($model, 'password_repeat', [
                    'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>{input}</div>',
                ])
                    ->passwordInput([
                        'maxlength' => true,
                        'class' => 'form-control',
                        'placeholder' => 'Repetir contraseña',
                    ])
                    ->label(false) ?>
            </div>
        </div>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> Aceptar', ['class' => 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
