<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_host_service".
 *
 * @property string $hostname
 * @property string $service_name
 */
class HostService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_host_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hostname', 'service_name'], 'string', 'max' => 255],
            [['hostname', 'service_name'], 'unique', 'targetAttribute' => ['hostname', 'service_name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hostname' => 'Hostname',
            'service_name' => 'Service Name',
        ];
    }
}
