<?php


namespace app\models;


use yii\base\Model;

class ResetPasswordModel extends Model
{

    public $email;

    public function rules()
    {
        return [
            [['email'], 'required'],
            ['email', 'email'],
        ];
    }
}