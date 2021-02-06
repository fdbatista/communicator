<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\entities\User */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

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

    <?= $form->field($model, 'full_name', [
        'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-text-width"></i></span>{input}</div>',
    ])
        ->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => 'Nombre completo',
        ])
        ->label(false) ?>

    <?= $form->field($model, 'password', [
        'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>{input}</div>',
    ])
        ->passwordInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => 'Contraseña',
        ])
        ->label(false) ?>

    <?= $form->field($model, 'mobile_number', [
        'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>{input}</div>',
    ])
        ->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => 'Teléfono',
        ])
        ->label(false) ?>

    <?= $form->field($model, 'email', [
        'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>{input}</div>',
    ])
        ->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => 'Email',
        ])
        ->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> Aceptar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
