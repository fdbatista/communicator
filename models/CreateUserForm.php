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

    public function rules()
    {
        return [
            [['user_name', 'full_name', 'password', 'password_repeat', 'email'], 'required'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['email', 'email']
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
