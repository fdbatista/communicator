<?php

namespace app\controllers;

use yii\web\Controller;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        date_default_timezone_set('America/Mexico_City');

        return parent::beforeAction($action);
    }
}
