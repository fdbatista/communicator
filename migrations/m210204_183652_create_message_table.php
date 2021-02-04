<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message}}`.
 */
class m210204_183652_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull()->defaultValue(1),
            'unread' => $this->integer()->notNull()->defaultValue(1),
            'sender_id' => $this->integer()->notNull(),
            'recipient_id' => $this->integer()->notNull(),
            'subject' => $this->string()->notNull(),
            'body' => $this->text()->notNull(),
            'date_sent' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'date_received' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%message}}');
    }
}
