<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m210204_181158_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'user_name' => $this->string(32)->notNull()->unique(),
            'full_name' => $this->string(128)->notNull(),
            'password' => $this->string()->notNull(),
            'auth_token' => $this->string(),
            'mobile_number' => $this->string()->unique(),
            'email' => $this->string(128)->notNull()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
