<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_fw_app_set".
 *
 * @property int $id
 * @property string $fw_name
 * @property string $app_set_name
 * @property string $app_sub_type
 * @property string $app_sub_name
 */
class FwAppSet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_fw_app_set';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fw_name', 'app_set_name', 'app_sub_type', 'app_sub_name'], 'string', 'max' => 255],
            [['fw_name', 'app_set_name', 'app_sub_name'], 'unique', 'targetAttribute' => ['fw_name', 'app_set_name', 'app_sub_name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fw_name' => 'Fw Name',
            'app_set_name' => 'App Set Name',
            'app_sub_type' => 'App Sub Type',
            'app_sub_name' => 'App Sub Name',
        ];
    }
}
