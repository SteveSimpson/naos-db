<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_nmap_port".
 *
 * @property int $id
 * @property int $host_id
 * @property int $port
 * @property string $protocol
 * @property string $state
 * @property string $state_reason
 * @property int $state_reason_ttl
 * @property string $service_name
 * @property string $service_product
 * @property string $service_version
 * @property string $service_extrainfo
 * @property string $service_method
 * @property string $service_conf
 * @property string $cpe
 * @property string $scripts
 */
class NmapPort extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_nmap_port';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['host_id', 'port', 'state_reason_ttl'], 'integer'],
            [['cpe', 'scripts'], 'string'],
            [['protocol', 'state', 'state_reason', 'service_name', 'service_product', 'service_version', 'service_extrainfo', 'service_method', 'service_conf'], 'string', 'max' => 255],
            [['host_id', 'port', 'protocol'], 'unique', 'targetAttribute' => ['host_id', 'port', 'protocol']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'host_id' => 'Host ID',
            'port' => 'Port',
            'protocol' => 'Protocol',
            'state' => 'State',
            'state_reason' => 'State Reason',
            'state_reason_ttl' => 'State Reason Ttl',
            'service_name' => 'Service Name',
            'service_product' => 'Service Product',
            'service_version' => 'Service Version',
            'service_extrainfo' => 'Service Extrainfo',
            'service_method' => 'Service Method',
            'service_conf' => 'Service Conf',
            'cpe' => 'Cpe',
            'scripts' => 'Scripts',
        ];
    }
}
