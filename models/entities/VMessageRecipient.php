<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "v_message_recipient".
 *
 * @property int $id
 * @property int $message_id
 * @property string $sender
 * @property int $recipient_id
 * @property string $subject
 * @property string $body
 * @property string $created_at
 * @property int $unread
 */
class VMessageRecipient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'v_message_recipient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'message_id', 'recipient_id', 'unread'], 'integer'],
            [['sender', 'recipient_id', 'subject', 'body'], 'required'],
            [['body'], 'string'],
            [['created_at'], 'safe'],
            [['sender'], 'string', 'max' => 128],
            [['subject'], 'string', 'max' => 255],
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
            'sender' => Yii::t('app', 'Sender'),
            'recipient_id' => Yii::t('app', 'Recipient ID'),
            'subject' => Yii::t('app', 'Subject'),
            'body' => Yii::t('app', 'Body'),
            'created_at' => Yii::t('app', 'Created At'),
            'unread' => Yii::t('app', 'Unread'),
        ];
    }

    public static function primaryKey()
    {
        return ['id'];
    }
}
