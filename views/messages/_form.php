<?php

use app\assets\SummernoteAsset;
use app\utils\MessageRecipientsUtil;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\entities\Message */
/* @var $form yii\widgets\ActiveForm */

SummernoteAsset::register($this);
?>

<div class="message-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <label for="recipients">Destinatarios</label>
                <?= Select2::widget([
                    'name' => 'recipients',
                    'value' => MessageRecipientsUtil::getMessageRecipientsIds($model->id),
                    'data' => MessageRecipientsUtil::getAvailableRecipients(),
                    'theme' => Select2::THEME_DEFAULT,
                    'options' => ['multiple' => true, 'placeholder' => 'Seleccione'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'subject')->textInput()->label('Asunto') ?>
            </div>
        </div>

        <div class="row" style="padding-bottom: 20px">
            <div class="col-lg-10">
                <?= $form->field($model, 'body')->textarea(['class' => 'summernote'])->label('Mensaje') ?>
            </div>
        </div>

        <div class="row" style="margin-left: 0">
            <div class="form-group">
                <?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> Enviar', ['class' => 'btn btn-info']) ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
