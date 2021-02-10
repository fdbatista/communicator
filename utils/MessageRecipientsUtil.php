<?php

namespace app\utils;

use app\models\entities\Message;
use app\models\entities\MessageRecipient;
use app\models\User;

class MessageRecipientsUtil
{
    public static function getAvailableRecipients()
    {
        $myId = AuthUtil::getMyId();

        $users = User::find()
            ->where("id <> $myId")
            ->select(['id', 'full_name'])
            ->all();

        $result = [];

        foreach ($users as $user) {
            $result[$user->id] = EncryptUtil::decrypt($user->full_name);
        }

        return $result;
    }

    public static function readBy($messageId)
    {
        $models = MessageRecipient::findAll([
            'message_id' => $messageId,
            'unread' => 0,
        ]);

        return array_map(function (MessageRecipient $recipient) {
            return $recipient->getRecipient()->one()->full_name;
        }, $models);
    }

    public static function getMessageRecipientsIds($messageId)
    {
        $models = MessageRecipient::findAll([
            'message_id' => $messageId,
        ]);

        return array_map(function (MessageRecipient $recipient) {
            return $recipient->getRecipient()->one()->id;
        }, $models);
    }

    public static function getMessageRecipientsNames(Message $message)
    {
        $recipients = $message->getRecipients()->select('full_name')->all();

        return array_map(function ($user) {
            return $user->full_name;
        }, $recipients);
    }

    public static function isUnreadForMe($messageId)
    {
        return MessageRecipient::find()
            ->where([
                'message_id' => $messageId,
                'recipient_id' => AuthUtil::getMyId(),
                'unread' => 1,
            ])->exists();
    }

}