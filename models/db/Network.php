<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_network".
 *
 * @property int $id
 * @property string $network_name
 * @property string $location_name
 * @property string $prefix4
 * @property string $prefix6
 * @property string $mask4
 * @property string $mask6
 * @property string $dnsdomain
 * @property string $notes
 * @property string $range4
 */
class Network extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_network';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notes'], 'string'],
            [['network_name', 'location_name', 'prefix4', 'prefix6', 'mask4', 'mask6', 'dnsdomain', 'range4'], 'string', 'max' => 255],
            [['network_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'network_name' => 'Network Name',
            'location_name' => 'Location Name',
            'prefix4' => 'Prefix for IPv4',
            'prefix6' => 'Prefix for IPv6',
            'mask4' => 'IPv4 Netmask (CIDR)',
            'netmask' => 'IPv4 Netmask',
            'mask6' => 'IPv6 Netmask',
            'dnsdomain' => 'DNS Domain',
            'notes' => 'Notes',
            'range4' => 'IPv4 Range',
        ];
    }
    
    public function getNetmask()
    {
        $mask = intval($this->mask4);
        
        if ($mask >= 0 && $this->mask4 <= 32) {
            
            $ipInt = 0;
            for($i = 0; $i <=$mask; $i++) {
                $ipInt += pow(2, 32-$i);
            }
            return long2ip($ipInt);
        } else {
            return "";
        }
    }
}
