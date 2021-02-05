<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $user_name
 * @property string $full_name
 * @property string $password
 * @property string|null $auth_token
 * @property string|null $mobile_number
 * @property string $email
 *
 * @property Message[] $messages
 * @property MessageRecipient[] $messageRecipients
 * @property Message[] $messages0
 * @property RoleUser[] $roleUsers
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_name', 'full_name', 'password', 'email'], 'required'],
            [['user_name'], 'string', 'max' => 32],
            [['full_name', 'email'], 'string', 'max' => 128],
            [['password', 'auth_token', 'mobile_number'], 'string', 'max' => 255],
            [['user_name'], 'unique'],
            [['email'], 'unique'],
            [['mobile_number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_name' => Yii::t('app', 'User Name'),
            'full_name' => Yii::t('app', 'Full Name'),
            'password' => Yii::t('app', 'Password'),
            'auth_token' => Yii::t('app', 'Auth Token'),
            'mobile_number' => Yii::t('app', 'Mobile Number'),
            'email' => Yii::t('app', 'Email'),
        ];
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['sender_id' => 'id']);
    }

    /**
     * Gets query for [[MessageRecipients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessageRecipients()
    {
        return $this->hasMany(MessageRecipient::className(), ['recipient_id' => 'id']);
    }

    /**
     * Gets query for [[Messages0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Message::className(), ['id' => 'message_id'])->viaTable('message_recipient', ['recipient_id' => 'id']);
    }

    /**
     * Gets query for [[RoleUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoleUsers()
    {
        return $this->hasMany(RoleUser::className(), ['user_id' => 'id']);
    }
}
