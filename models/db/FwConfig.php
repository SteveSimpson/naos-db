<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_fw_config".
 *
 * @property int $id
 * @property string $fw_name
 * @property string $fw_type
 * @property string $fw_config
 * @property string $notes
 */
class FwConfig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_fw_config';
    }
    
    public static function types()
    {
        return [
            'juniper' => 'Juniper',
            'cisco' => 'Cisco',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notes', 'fw_config'], 'string'],
            [['fw_name', 'fw_type'], 'string', 'max' => 255],
            [['fw_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fw_name' => 'Firewall Name',
            'fw_type' => 'Firewall Type',
            'fw_config' => 'Config Text',
            'notes' => 'Notes',
        ];
    }
}
