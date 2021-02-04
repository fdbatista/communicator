<?php

use yii\db\Migration;

/**
 * Class m210204_193136_insert_role_users
 */
class m210204_193136_insert_role_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('role_user',
            ['role_id', 'user_id'],
            [[1, 1], [2, 2], [2, 3]]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210204_193136_insert_role_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210204_193136_insert_role_users cannot be reverted.\n";

        return false;
    }
    */
}
