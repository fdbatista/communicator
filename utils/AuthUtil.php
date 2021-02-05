<?php

namespace app\utils;

use Yii;

class AuthUtil
{
    public static function iAmAdmin()
    {
        return Yii::$app->user->identity->isAdmin();
    }

    public static function getMyId()
    {
        return Yii::$app->user->identity->getId();
    }
}
