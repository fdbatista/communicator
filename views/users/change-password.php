<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ChangePasswordForm */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = 'Cambiar clave';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'old_password', [
                'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>{input}</div>',
            ])
                ->passwordInput([
                    'autofocus' => true,
                    'maxlength' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Contraseña vigente',
                ])
                ->label(false) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'new_password', [
                'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>{input}</div>',
            ])
                ->passwordInput([
                    'maxlength' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Nueva contraseña',
                ])
                ->label(false) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'password_repeat', [
                'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>{input}</div>',
            ])
                ->passwordInput([
                    'maxlength' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Repetir nueva contraseña',
                ])
                ->label(false) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> Aceptar', ['class' => 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
