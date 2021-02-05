<?php

/* @var $this yii\web\View */
/* @var $model app\models\entities\Message */

$this->title = 'Editar mensaje';
$this->params['breadcrumbs'][] = ['label' => 'Mensajes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="message-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
