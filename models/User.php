<?php

namespace app\models;

use app\models\entities\User as UserEntity;
use Yii;
use yii\web\IdentityInterface;

class User extends UserEntity implements IdentityInterface
{

    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return User::findOne(['auth_token' => $token]);
    }

    public static function findByUsername($username)
    {
        return User::findOne(['user_name' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_token;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_token === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

}
