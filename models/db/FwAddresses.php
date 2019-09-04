<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_fw_addresses".
 *
 * @property int $id
 * @property string $fw_name
 * @property string $fw_zone
 * @property string $name
 * @property string $ip
 */
class FwAddresses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_fw_addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fw_name', 'fw_zone', 'name', 'ip'], 'string', 'max' => 255],
            [['fw_name', 'fw_zone', 'name'], 'unique', 'targetAttribute' => ['fw_name', 'fw_zone', 'name']],
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
            'fw_zone' => 'Fw Zone',
            'name' => 'Name',
            'ip' => 'Ip',
        ];
    }
}
