<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CreateUserForm extends Model
{
    public $user_name;
    public $full_name;
    public $password;
    public $password_repeat;
    public $mobile_number;
    public $email;
    public $isNewRecord;

    public function __construct()
    {
        parent::__construct();
        $this->isNewRecord = true;
    }

    public function rules()
    {
        return [
            [['user_name', 'full_name', 'password', 'password_repeat', 'email'], 'required'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['email', 'email']
        ];
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

}
