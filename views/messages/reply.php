<?php

/* @var $this yii\web\View */
/* @var $model app\models\entities\Message */

$this->title = 'Responder mensaje';
$this->params['breadcrumbs'][] = ['label' => 'Mensajes', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Responder';
?>
<div class="message-update">

    <?= $this->render('_form', [
        'model' => $model,
        'showRecipients' => false,
    ]) ?>

</div>
