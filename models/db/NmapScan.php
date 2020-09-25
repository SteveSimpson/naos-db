<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_nmap_scan".
 *
 * @property int $id
 * @property string $args
 * @property int $start
 * @property string $version
 * @property int $finish
 * @property string $summary
 * @property string $exit
 * @property int $hosts_up
 * @property int $hosts_down
 */
class NmapScan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_nmap_scan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start', 'finish', 'hosts_up', 'hosts_down'], 'integer'],
            [['args', 'version', 'summary', 'exit'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'args' => 'Args',
            'start' => 'Start',
            'version' => 'Version',
            'finish' => 'Finish',
            'summary' => 'Summary',
            'exit' => 'Exit',
            'hosts_up' => 'Hosts Up',
            'hosts_down' => 'Hosts Down',
        ];
    }
}
