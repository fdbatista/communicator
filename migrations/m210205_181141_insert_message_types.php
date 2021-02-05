<?php

use yii\db\Migration;

/**
 * Class m210205_181141_insert_message_types
 */
class m210205_181141_insert_message_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('message_type',
            ['name'],
            [['Web']]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210205_181141_insert_message_types cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210205_181141_insert_message_types cannot be reverted.\n";

        return false;
    }
    */
}
