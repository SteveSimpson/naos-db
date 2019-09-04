<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_fw_app".
 *
 * set applications application nuttcp term nuttcp protocol tcp
 * set applications application nuttcp term nuttcp source-port 0-65535
 * set applications application nuttcp term nuttcp destination-port 5000-5000
 * set applications application nuttcp term nuttcp inactivity-timeout 60
 *
 * @property int $id
 * @property string $fw_name
 * @property string $app_name
 * @property string $app_line
 * @property string $protocol
 * @property string $source_port
 * @property string $destination_port
 * @property string $inactivity_timeout
 */
class FwApp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_fw_app';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fw_name', 'app_name', 'app_line', 'protocol', 'source_port', 'destination_port', 'inactivity_timeout'], 'string', 'max' => 255],
            [['fw_name', 'app_name', 'app_line'], 'unique', 'targetAttribute' => ['fw_name', 'app_name', 'app_line']],
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
            'app_name' => 'App Name',
            'app_line' => 'App Line',
            'protocol' => 'Protocol',
            'source_port' => 'Source Port',
            'destination_port' => 'Destination Port',
            'inactivity_timeout' => 'Inactivity Timeout',
        ];
    }
}
