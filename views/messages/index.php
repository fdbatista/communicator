<?php

use app\models\entities\Message;
use app\utils\AuthUtil;
use kartik\daterange\DateRangePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mensajes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">
    <p>
        <?php
        if (AuthUtil::iAmAdmin())
            echo Html::a('<i class="glyphicon glyphicon-plus-sign"></i> Redactar', ['create'], ['class' => 'btn btn-success']);
        ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'sender',
                'label' => 'Remitente',
                'value' => 'sender.full_name',
            ],

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
                'attribute' => 'subject',
                'label' => 'Asunto',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, Message $model) {
                        return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', Url::to(['view', 'id' => $model->id]), ['data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Ver"]);
                    },
                    'update' => function ($url, Message $model) {
                        return AuthUtil::iAmAdmin()
                            ? Html::a('<i class="glyphicon glyphicon-edit"></i>', Url::to(['update', 'id' => $model->id]), ['data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Editar"])
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
