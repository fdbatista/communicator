<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message}}`.
 */
class m210204_183661_create_message_recipient_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message_recipient}}', [
            'id' => $this->primaryKey(),
            'message_id' => $this->integer()->notNull(),
            'recipient_id' => $this->integer()->notNull(),
            'unread' => $this->integer()->notNull()->defaultValue(1),
            'read_at' => $this->dateTime(),
        ]);

        $this->createIndex('idx_message_recipient_unique', 'message_recipient', 'message_id, recipient_id', true);
        $this->createIndex('idx_message_recip_unread', 'message_recipient', 'unread');

        $this->addForeignKey('fk_message_recipient_message', 'message_recipient', 'message_id', 'message', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_message_recipient_recipient', 'message_recipient', 'recipient_id', 'user', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%message}}');
    }
}
