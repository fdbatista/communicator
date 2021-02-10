<?php

use yii\db\Migration;

/**
 * Class m210205_231955_create_view_message_recipient
 */
class m210205_231955_create_view_message_recipient extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $command = 'create or replace view `v_message_recipient` as
            SELECT
                `message_recipient`.`id`,
                `message`.`id` as `message_id`,
                `user`.`full_name` as `sender`,
                `message_recipient`.`recipient_id`,
                `message`.`subject`,
                `message`.`body`,
                `message`.`created_at`,
                `message_recipient`.`unread`
                FROM `message_recipient`
                INNER JOIN `message` on (`message_id` = `message`.`id`)
                INNER JOIN `user` on (`user`.id = `message`.`sender_id`)
        ';
        Yii::$app->db->createCommand($command)
            ->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210205_231955_create_view_message_recipient cannot be reverted.\n";

        return false;
    }

}
