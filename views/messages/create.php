<?php

/* @var $this yii\web\View */
/* @var $model app\models\entities\Message */

$this->title = 'Redactar';
$this->params['breadcrumbs'][] = ['label' => 'Mensajes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
