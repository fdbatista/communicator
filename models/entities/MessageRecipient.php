<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "message_recipient".
 *
 * @property int $id
 * @property int $message_id
 * @property int $recipient_id
 * @property int $unread
 * @property string|null $read_at
 *
 * @property Message $message
 * @property User $recipient
 */
class MessageRecipient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message_recipient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message_id', 'recipient_id'], 'required'],
            [['message_id', 'recipient_id', 'unread'], 'integer'],
            [['read_at'], 'safe'],
            [['message_id', 'recipient_id'], 'unique', 'targetAttribute' => ['message_id', 'recipient_id']],
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => Message::className(), 'targetAttribute' => ['message_id' => 'id']],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['recipient_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'message_id' => Yii::t('app', 'Message ID'),
            'recipient_id' => Yii::t('app', 'Recipient ID'),
            'unread' => Yii::t('app', 'Unread'),
            'read_at' => Yii::t('app', 'Read At'),
        ];
    }

    /**
     * Gets query for [[Message]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'message_id']);
    }

    /**
     * Gets query for [[Recipient]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
    }
}
