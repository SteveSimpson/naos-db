<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_host".
 *
 * @property int $id
 * @property string $hostname
 * @property string $fqdn
 * @property string $network_name
 * @property string $location_name
 * @property string $service
 * @property string $ipv4
 * @property string $ipv6
 * @property string $mask4
 * @property string $mask6
 * @property string $monitor_ip
 * @property int $enabled
 * @property string $notes
 * @property string $type
 */
class Host extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_host';
    }
    
    public $host_ip_last;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['enabled','host_ip_last'], 'integer'],
            [['notes'], 'string'],
            [['hostname', 'fqdn', 'network_name', 'location_name', 'service', 'ipv4', 'ipv6', 'mask4', 'mask6', 'monitor_ip', 'type'], 'string', 'max' => 255],
            [['fqdn'], 'unique'],
            [['hostname'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hostname' => 'Hostname',
            'host_ip_last' => 'Last Part of Host IP',
            'fqdn' => 'FQDN',
            'network_name' => 'Network Name',
            'location_name' => 'Location Name',
            'service' => 'Service Description',
            'ipv4' => 'IPv4',
            'ipv6' => 'IPv6',
            'mask4' => 'IPv4 Netmask',
            'mask6' => 'IPv6 Netmask',
            'monitor_ip' => 'Monitor IP',
            'enabled' => 'Enabled',
            'notes' => 'Notes',
            'type' => 'Type',
        ];
    }
    
    /** 
     * this maps to nagios template types
     * 
     * @return string[]
     */
    public static function listTypes()
    {
        return [
            'linux-server'    => 'linux-server',
            'windows-server'  => 'windows-server',
            'generic-host'    => 'generic-host',
            'generic-printer' => 'generic-printer',
            'generic-switch'  => 'generic-switch',
            'generic-router'  => 'generic-router',
        ];
    }
}
