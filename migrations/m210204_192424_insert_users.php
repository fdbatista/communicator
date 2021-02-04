<?php

use yii\db\Migration;

/**
 * Class m210204_192424_insert_users
 */
class m210204_192424_insert_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('user',
            ['user_name', 'full_name', 'password', 'auth_token', 'email'],
            [
                ['admin', 'Admin', Yii::$app->security->generatePasswordHash('a'), Yii::$app->security->generateRandomString(), 'admin@server.com'],
                ['user1', 'Usuario Uno', Yii::$app->security->generatePasswordHash('a'), Yii::$app->security->generateRandomString(), 'user1@server.com'],
                ['user2', 'Usuario Dos', Yii::$app->security->generatePasswordHash('a'), Yii::$app->security->generateRandomString(), 'user2@server.com'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210204_192424_insert_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210204_192424_insert_users cannot be reverted.\n";

        return false;
    }
    */
}
