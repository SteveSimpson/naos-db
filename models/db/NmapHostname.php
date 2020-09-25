<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_nmap_hostname".
 *
 * @property int $id
 * @property int $host_id
 * @property string $hostname
 * @property string $type
 */
class NmapHostname extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_nmap_hostname';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['host_id'], 'integer'],
            [['hostname', 'type'], 'string', 'max' => 255],
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
            'hostname' => 'Hostname',
            'type' => 'Type',
        ];
    }
}
