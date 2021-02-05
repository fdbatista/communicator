<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property int $type_id
 * @property int $unread
 * @property int $sender_id
 * @property int $recipient_id
 * @property string $subject
 * @property string $body
 * @property string $date_sent
 * @property string|null $date_received
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
            [['type_id', 'unread', 'sender_id', 'recipient_id'], 'integer'],
            [['sender_id', 'recipient_id', 'subject', 'body'], 'required'],
            [['body'], 'string'],
            [['date_sent', 'date_received'], 'safe'],
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
            'type_id' => Yii::t('app', 'Type ID'),
            'unread' => Yii::t('app', 'Unread'),
            'sender_id' => Yii::t('app', 'Sender ID'),
            'recipient_id' => Yii::t('app', 'Recipient ID'),
            'subject' => Yii::t('app', 'Subject'),
            'body' => Yii::t('app', 'Body'),
            'date_sent' => Yii::t('app', 'Date Sent'),
            'date_received' => Yii::t('app', 'Date Received'),
        ];
    }
}
