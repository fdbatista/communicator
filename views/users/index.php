<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('<i class="glyphicon glyphicon-plus-sign"></i> Crear usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'user_name',
                'label' => 'Usuario',
            ],

            [
                'attribute' => 'full_name',
                'label' => 'Nombre completo',
            ],

            'email:email',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $url, ['data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Ver"]);
                    },
                    'update' => function ($url) {
                        return Html::a('<i class="glyphicon glyphicon-edit"></i>', $url, ['data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Editar"]);
                    },
                    'delete' => function ($url) {
                        return Html::a('<i class="glyphicon glyphicon-trash"></i>', $url, ['data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Eliminar", 'data' => [
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
