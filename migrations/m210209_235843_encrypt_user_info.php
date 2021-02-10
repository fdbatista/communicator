<?php

use app\models\entities\User;
use app\utils\EncryptUtil;
use yii\db\Migration;

/**
 * Class m210209_235843_encrypt_user_info
 */
class m210209_235843_encrypt_user_info extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $users = User::find()->all();
        $transaction = Yii::$app->db->beginTransaction();

        foreach ($users as $user) {
            $user->updateAttributes([
                'user_name' => EncryptUtil::encrypt($user->user_name),
                'full_name' => EncryptUtil::encrypt($user->full_name),
                'email' => EncryptUtil::encrypt($user->email),
            ]);
        }

        $transaction->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210209_235843_encrypt_user_info cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210209_235843_encrypt_user_info cannot be reverted.\n";

        return false;
    }
    */
}
