<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property RoleUser[] $roleUsers
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * Gets query for [[RoleUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoleUsers()
    {
        return $this->hasMany(RoleUser::className(), ['role_id' => 'id']);
    }
}
