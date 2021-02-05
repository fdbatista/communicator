<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->registerCssFile('@web/css/login.css');
$this->title = 'Acceder';
?>

<div class="container">
    <div id="login-box" class="row form-box">
        <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <?= Html::img('@web/img/logo_no_text.png', ['height' => '20px']) ?>
                        <span>Bienvenido(a) a <b>bee</b>per</span>
                    </div>
                </div>

                <div class="panel-body">
                    <?php if ($model->hasErrors('password')) { ?>
                        <div class="alert alert-danger small">
                            <i class="glyphicon glyphicon-alert"></i>
                            <span style="margin-left: 5px"><?= $model->errors['password'][0] ?></span>
                        </div>
                    <?php } ?>

                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                    ]); ?>

                    <?= $form->field($model, 'username', [
                        'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>{input}</div>',
                    ])
                        ->textInput([
                            'id' => 'login-username',
                            'autofocus' => true,
                            'class' => 'form-control',
                            'placeholder' => 'Nombre de usuario',
                        ])
                        ->label(false)->error(false) ?>


                    <?= $form->field($model, 'password', [
                        'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>{input}</div>',
                    ])
                        ->passwordInput([
                            'class' => 'form-control',
                            'placeholder' => 'Contraseña',
                        ])
                        ->label(false)->error(false) ?>

                    <div class="form-group">
                        <div class="col-sm-12" style="margin-left: -15px; padding-top: 20px !important;">
                            <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> Aceptar', [
                                'class' => 'btn btn-primary'
                            ]) ?>
                        </div>
                        <div class="switch-form">
                            <a href="#"
                               onClick="$('#login-box').hide(); $('#reset-password-box').show(); $('#reset-password-email').focus();">
                                ¿Olvidaste tu contrase&ntilde;a?
                            </a>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

    <div id="reset-password-box" class="row form-box" style="display: none;">
        <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <?= Html::img('@web/img/logo_no_text.png', ['height' => '20px']) ?>
                        <span>Bienvenido(a) a <b>bee</b>per</span>
                    </div>

                </div>

                <div class="panel-body">
                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12">
                        <i class="glyphicon glyphicon-alert"></i>
                        <span style="margin-left: 5px">123</span>
                    </div>

                    <?php $form = ActiveForm::begin([
                        'id' => 'reset-password-form',
                    ]); ?>

                    <?= $form->field($model, 'username', [
                        'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>{input}</div>',
                    ])
                        ->textInput([
                            'id' => 'reset-password-email',
                            'type' => 'email',
                            'class' => 'form-control',
                            'placeholder' => 'Email',
                        ])
                        ->label(false)->error(false) ?>

                    <div class="form-group">
                        <div class="col-sm-12" style="margin-left: -15px; padding-top: 20px !important;">
                            <?= Html::submitButton('<i class="glyphicon glyphicon-refresh"></i> Recuperar', [
                                'class' => 'btn btn-primary'
                            ]) ?>
                        </div>
                        <div class="switch-form">
                            <a id="sign-in-link" href="#"
                               onclick="$('#reset-password-box').hide(); $('#login-box').show(); $('#login-username').focus();">
                                Acceder
                            </a>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
