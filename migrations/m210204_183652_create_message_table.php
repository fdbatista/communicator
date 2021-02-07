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
            'sender_id' => $this->integer()->notNull(),
            'subject' => $this->string()->notNull(),
            'body' => 'LONGTEXT',
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('fk_message_type', 'message', 'type_id', 'message_type', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_message_sender', 'message', 'sender_id', 'user', 'id', 'cascade', 'cascade');

        $this->createIndex('idx_message_created_at', 'message', 'created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%message}}');
    }
}
