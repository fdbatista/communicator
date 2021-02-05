<?php

namespace app\utils;

use Yii;
use yii\helpers\Html;

class MenuUtil
{
    public static function getMenuItems()
    {
        return [
            ['label' => '<i class="glyphicon glyphicon-home"></i> Inicio', 'url' => ['/messages/index']],
            ['label' => '<i class="glyphicon glyphicon-info-sign"></i> Acerca de', 'url' => ['/site/about']],
            [
                'label' => '<i class="glyphicon glyphicon-user"></i> ',
                'items' => [
                    '<li class="dropdown-header">' . Yii::$app->user->identity->user_name . '</li>',
                    (
                        '<li class="dropdown-item">'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton('<i class="glyphicon glyphicon-log-out"></i> Salir', ['class' => 'btn  btn-link logout'])
                        . Html::endForm()
                        . '</li>'
                    ),
                ],
            ],
        ];
    }
}