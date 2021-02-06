<?php

use kartik\daterange\DateRangePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\VMessageRecipientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mensajes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vmessage-recipient-index">
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
                            'format' => 'Y-m-d H:i',
                        ],
                    ],
                ]),
            ],

            [
                'attribute' => 'sender',
                'label' => 'Remitente',
                'format' => 'raw',
                'value' => function($searchModel) {
                    $spanClass = $searchModel->unread === 1 ? 'unread-message' : '';
                    return "<span class='$spanClass'>$searchModel->sender</span>";
                },
            ],

            [
                'attribute' => 'subject',
                'label' => 'Asunto',
                'format' => 'raw',
                'value' => function($searchModel) {
                    $spanClass = $searchModel->unread === 1 ? 'unread-message' : '';
                    return "<span class='$spanClass'>$searchModel->subject</span>";
                },
            ],

            [
                'attribute' => 'unread',
                'label' => 'Estado',
                'format' => 'raw',
                'value' => function ($searchModel) {
                    $spanClass = $searchModel->unread === 1 ? 'unread-message' : '';
                    $value = $searchModel->unread === 1 ? 'Sin leer' : 'Leído';

                    return "<span class='$spanClass'>$value</span>";
                },
                'filter' => [
                    0 => "Leído",
                    1 => "Sin leer"
                ],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', Url::to(['view', 'id' => $model->message_id]), ['data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Ver"]);
                    },
                    'delete' => function ($url, $model) {
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
