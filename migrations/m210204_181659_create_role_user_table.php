<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_role}}`.
 */
class m210204_181659_create_role_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%role_user}}', [
            'id' => $this->primaryKey(),
            'role_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_role_user_role', 'role_user', 'role_id', 'role', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_role_user_user', 'role_user', 'user_id', 'user', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_role}}');
    }
}
