<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property int $type_id
 * @property int $sender_id
 * @property string $subject
 * @property string $body
 * @property string $created_at
 *
 * @property User $sender
 * @property MessageType $type
 * @property MessageRecipient[] $messageRecipients
 * @property User[] $recipients
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'sender_id'], 'integer'],
            [['sender_id', 'subject', 'body'], 'required'],
            [['body'], 'string'],
            [['created_at'], 'safe'],
            [['subject'], 'string', 'max' => 255],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => MessageType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type_id' => Yii::t('app', 'Type ID'),
            'sender_id' => Yii::t('app', 'Sender ID'),
            'subject' => Yii::t('app', 'Subject'),
            'body' => Yii::t('app', 'Body'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[Sender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(MessageType::className(), ['id' => 'type_id']);
    }

    /**
     * Gets query for [[MessageRecipients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessageRecipients()
    {
        return $this->hasMany(MessageRecipient::className(), ['message_id' => 'id']);
    }

    /**
     * Gets query for [[Recipients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipients()
    {
        return $this->hasMany(User::className(), ['id' => 'recipient_id'])->viaTable('message_recipient', ['message_id' => 'id']);
    }
}
