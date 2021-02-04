<?php

use yii\db\Migration;

/**
 * Class m210204_191915_insert_roles
 */
class m210204_191915_insert_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('role',
            ['name'],
            [['Administrador'], ['Usuario']]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210204_191915_insert_roles cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210204_191915_insert_roles cannot be reverted.\n";

        return false;
    }
    */
}
