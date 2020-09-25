<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_nmap_host".
 *
 * @property int $id
 * @property string $IPv4
 * @property string $IPv6
 * @property int $starttime
 * @property int $stoptime
 * @property string $hostname
 * @property string $state
 * @property string $state_reason
 * @property string $os
 * @property int $os_percent
 * @property int $uptime_seconds
 * @property string $uptime_lastboot
 * @property string $tcpsequence_difficulty
 * @property int $last_scan_id
 */
class NmapHost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_nmap_host';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['starttime', 'stoptime', 'os_percent', 'uptime_seconds', 'last_scan_id'], 'integer'],
            [['IPv4', 'IPv6', 'hostname', 'state', 'state_reason', 'os', 'uptime_lastboot', 'tcpsequence_difficulty'], 'string', 'max' => 255],
            [['IPv4', 'IPv6'], 'unique', 'targetAttribute' => ['IPv4', 'IPv6']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'IPv4' => 'I Pv4',
            'IPv6' => 'I Pv6',
            'starttime' => 'Starttime',
            'stoptime' => 'Stoptime',
            'hostname' => 'Hostname',
            'state' => 'State',
            'state_reason' => 'State Reason',
            'os' => 'Os',
            'os_percent' => 'Os Percent',
            'uptime_seconds' => 'Uptime Seconds',
            'uptime_lastboot' => 'Uptime Lastboot',
            'tcpsequence_difficulty' => 'Tcpsequence Difficulty',
            'last_scan_id' => 'Last Scan ID',
        ];
    }
}
