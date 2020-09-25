<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_nmap_port_info".
 *
 * @property string $id
 * @property int $host_id
 * @property int $port_id
 * @property string $type
 * @property string $text
 */
class NmapPortInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_nmap_port_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['host_id', 'port_id'], 'integer'],
            [['text'], 'string'],
            [['id', 'type'], 'string', 'max' => 255],
            [['host_id', 'port_id'], 'unique', 'targetAttribute' => ['host_id', 'port_id']],
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
            'port_id' => 'Port ID',
            'type' => 'Type',
            'text' => 'Text',
        ];
    }
}
