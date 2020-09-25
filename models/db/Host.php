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
 * @property int $ipv4int
 * @property int $os_id
 * @property int $virtual
 * @property string $make
 * @property string $model
 * @property string $serial
 * @property int $dod_approval
 * @property int $critical
 * @property int $hw_show
 * 
 * @property Os $os
 * @property Network $network
 * @property Location $location
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
            [['enabled', 'ipv4int', 'os_id', 'virtual', 'dod_approval', 'critical', 'hw_show'], 'integer'],
            [['notes'], 'string'],
            [['hostname', 'fqdn', 'network_name', 'location_name', 'service', 'ipv4', 'ipv6', 'mask4', 'mask6', 'monitor_ip', 'type', 'make', 'model', 'serial'], 'string', 'max' => 255],
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
            'ipv4int' => 'IPv4 Decimal',
            'os_id' => 'OS',
            'virtual' => 'Virtual Asset',
            'make' => 'Manufacturer',
            'model' => 'Model Number',
            'serial' => 'Serial Number',
            'dod_approval' => 'DoD Approval Status',
            'critical' => 'Critical Information System Asset',
            'hw_show' => 'Show on HW List',
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
            'linux-server'    => 'Server, Linux',
            'windows-server'  => 'Server, Windows',
            'osx-server'    => 'Server, OSX',
            'linux-workstation'    => 'Workstation, Linux',
            'windows-workstation'  => 'Workstation, Windows',
            'osx-workstation'    => 'Workstation, OSX',
            'generic-host'    => 'generic-host',
            'generic-printer' => 'generic-printer',
            'generic-switch'  => 'Switch',
            'generic-router'  => 'Router',
            'generic-firewall'  => 'Firewall',
            'generic-ids' => 'IDS/IPS',
            'generic-kvm' => 'KVM',
            'san-controller' => 'SAN Controller',
            'san-disk' => 'SAN Storage Disk',
            'generic-drac' => 'DRAC',
            'linux-cssp' => 'Server, CSSP Linux',
        ];
    }
    
    public static function listOs()
    {
        $data = Os::find()->select(['id', 'os_name_version'])->all();
        
        $array = [0 => ""];
        
        foreach($data as $os) {
            $array[$os->id] = $os->os_name_version;
        }
        
        return $array;
    }
    
    public function beforeSave($insert)
    {
        $this->ipv4int = ip2long($this->ipv4);
        
        return parent::beforeSave($insert);
    }
    
    public function getVirtual()
    {
        return intval($this->virtual);
    }
    
    /**
     * 
     * @return Os
     */
    public function getOs()
    {
        return $this->hasOne(Os::className(), ['id' => 'os_id']);
    }
    
    /**
     * 
     * @return Network
     */
    public function getNetwork()
    {
        return $this->hasOne(Network::className(), ['network_name' => 'network_name']);
    }
    
    /**
     * 
     * @return Location
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['location_name' => 'location_name']);
    }
}
