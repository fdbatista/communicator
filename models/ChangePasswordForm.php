<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $old_password;
    public $new_password;
    public $password_repeat;

    public function __construct()
    {
        parent::__construct();
    }

    public function rules()
    {
        return [
            [['old_password', 'new_password', 'password_repeat'], 'required'],
            ['password_repeat', 'compare', 'compareAttribute' => 'new_password'],
            ['old_password', 'validatePassword']
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = Yii::$app->user->identity;

            if (!$user || !$user->validatePassword($this->old_password)) {
                $this->addError($attribute, 'La contraseña actual es incorrecta');
            }
        }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

}
