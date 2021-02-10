<?php

use app\models\entities\Message;
use app\utils\AuthUtil;
use app\utils\EncryptUtil;
use app\utils\MessageRecipientsUtil;
use kartik\daterange\DateRangePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mensajes';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/reload_page.js', ['position' => View::POS_END]);
?>
<div class="message-index">
    <p>
        <?= Html::a('<i class="glyphicon glyphicon-plus-sign"></i> Redactar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Fecha',
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'Y-m-d H:i'
                        ],
                    ],
                ]),
            ],

            [
                'attribute' => 'sender',
                'label' => 'Remitente',
                'format' => 'raw',
                'value' => function (Message $model) {
                    $spanClass = MessageRecipientsUtil::isUnreadForMe($model->id) ? 'unread-message' : '';

                    return Html::a(EncryptUtil::decrypt($model->sender->full_name), Url::to(['view', 'id' => $model->id]), [
                        'class' => $spanClass,
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                        'title' => 'Ver mensaje'
                    ]);
                },
            ],

            [
                'attribute' => 'subject',
                'label' => 'Asunto',
                'format' => 'raw',
                'value' => function (Message $model) {
                    $spanClass = MessageRecipientsUtil::isUnreadForMe($model->id) ? 'unread-message' : '';

                    return Html::a(EncryptUtil::decrypt($model->subject), Url::to(['view', 'id' => $model->id]), [
                        'class' => $spanClass,
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                        'title' => 'Ver mensaje'
                    ]);
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{reply} {delete}',
                'buttons' => [
                    'reply' => function ($url, Message $model) {
                        return $model->sender_id !== AuthUtil::getMyId()
                            ? Html::a('<i class="glyphicon glyphicon-envelope"></i>', Url::to(['reply', 'id' => $model->id]), ['data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Responder"])
                            : '';
                    },
                    'delete' => function ($url, Message $model) {
                        return Html::a('<i class="glyphicon glyphicon-trash"></i>', Url::to(['delete', 'id' => $model->id]), ['data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Eliminar", 'data' => [
                            'confirm' => '¿Seguro que desea eliminar este mensaje?',
                            'method' => 'post',
                        ],]);
                    },
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
