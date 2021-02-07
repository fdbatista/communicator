<?php

use app\assets\SummernoteAsset;
use app\utils\AuthUtil;
use app\utils\MessageRecipientsUtil;
use kartik\editors\Summernote;
use yii\helpers\Html;
use yii\web\View;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\entities\Message */
/* @var $recipients */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mensajes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/view-message.css');
$this->registerJsFile('@web/js/make_summernote_read_only.js', [
    'position' => View::POS_END,
    'depends' => [yii\web\JqueryAsset::class]
]);

YiiAsset::register($this);
SummernoteAsset::register($this);
?>
<div class="message-view">

    <p>
        <?php
        if (AuthUtil::iAmAdmin())
            echo Html::a('<i class="glyphicon glyphicon-edit"></i> Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>

        <?php
        echo Html::a('<i class="glyphicon glyphicon-trash"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Seguro que desea eliminar este mensaje?',
                'method' => 'post',
            ],
        ]);
        ?>
    </p>

    <?php
    $attributes = [
        [
            'attribute' => 'created_at',
            'label' => 'Fecha',
            'format' => 'datetime',
        ],

        [
            'attribute' => 'sender',
            'label' => 'Remitente',
            'value' => $model->sender->full_name,
        ],

        [
            'attribute' => 'subject',
            'label' => 'Asunto'
        ],

        [
            'attribute' => 'body',
            'label' => 'Mensaje',
            'format' => 'raw',
            'value' => function ($model) {
                return "<textarea class='summernote'>$model->body</textarea>";
            }
        ],
    ];

    if (AuthUtil::iAmAdmin()) {
        $recipients = MessageRecipientsUtil::getMessageRecipientsNames($model);
        $readers = MessageRecipientsUtil::readBy($model->id);

        $attributes[] = [
            'label' => 'Enviado a',
            'value' => implode(', ', $recipients),
        ];

        $attributes[] = [
            'label' => 'Leído por',
            'value' => implode(', ', $readers),
        ];
    }

    echo DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>

</div>
