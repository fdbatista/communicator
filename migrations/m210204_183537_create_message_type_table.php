<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message_type}}`.
 */
class m210204_183537_create_message_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%message_type}}');
    }
}
