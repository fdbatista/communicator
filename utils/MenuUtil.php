<?php

namespace app\utils;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class MenuUtil
{
    public static function getMenuItems()
    {
        return [
            ['label' => '<i class="glyphicon glyphicon-home"></i> Inicio', 'url' => ['/messages/index']],
            self::buildManagementDropdown(),
            ['label' => '<i class="glyphicon glyphicon-info-sign"></i> Acerca de', 'url' => ['/site/about']],
            self::buildUserMenuDropdown()
        ];
    }

    private static function buildUserMenuDropdown() {
        return [
            'label' => '<i class="glyphicon glyphicon-user"></i>',
            'visible' => !Yii::$app->user->isGuest,
            'items' => [
                '<li class="dropdown-header">' . Yii::$app->user->identity->user_name . '</li>',
                (
                    '<li class="dropdown-item">'
                    . Html::a('<i class="glyphicon glyphicon-lock"></i> Cambiar clave', Url::to(['/users/change-password']), ['class' => 'btn btn-link logout'])
                    . '</li>'
                ),
                (
                    '<li class="dropdown-item">'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton('<i class="glyphicon glyphicon-off"></i> Salir', ['class' => 'btn btn-link logout'])
                    . Html::endForm()
                    . '</li>'
                ),
            ],
        ];
    }

    private static function buildManagementDropdown()
    {
        return [
            'label' => '<i class="glyphicon glyphicon-cog"></i> Administrar',
            'visible' => AuthUtil::iAmAdmin(),
            'items' => [
                    '<li class="dropdown-item">'
                    . Html::a('<i class="glyphicon glyphicon-user"></i> Usuarios', Url::to(['/users/index']), ['class' => 'btn btn-link'])
                    . '</li>',
            ],
        ];
    }
}