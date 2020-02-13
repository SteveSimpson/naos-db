<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_location".
 *
 * @property int $id
 * @property string $location_name
 * @property string $building
 * @property string $notes
 * 
 * @property Host[] $hosts
 * @property Network[] $networks
 */
class Location extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notes'], 'string'],
            [['location_name', 'building'], 'string', 'max' => 255],
            [['location_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location_name' => 'Location Name',
            'building' => 'Building',
            'notes' => 'Notes',
        ];
    }
    
    /**
     * 
     * @return Network[]
     */
    public function getNetworks()
    {
        return $this->hasMany(Network::className(), ['location_name' => 'location_name']);
    }
    
    /**
     * 
     * @return Host[]
     */
    public function getHosts()
    {
        return $this->hasMany(Host::className(), ['location_name' => 'location_name']);
    }
}

