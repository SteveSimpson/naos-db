<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_puppet_host".
 *
 * @property int $id
 * @property string $IPv4
 * @property string $IPv6
 * @property int $fact_time
 * @property int $last_report_time
 * @property string $hostname
 * @property string $state
 * @property string $facts
 * @property string $last_report
 * @property string $os
 * @property string $environment
 * @property string $configuration_version
 * @property string $puppet_version
 * @property string $status
 * @property string $transaction_completed
 */
class PuppetHost extends \yii\db\ActiveRecord
{
    private $_parser;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_puppet_host';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fact_time', 'last_report_time'], 'integer'],
            [['facts', 'last_report'], 'string'],
            [['IPv4', 'IPv6', 'hostname', 'state', 'os', 'environment', 'configuration_version', 'puppet_version', 'status', 'transaction_completed'], 'string', 'max' => 255],
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
            'IPv4' => 'I Pv4',
            'IPv6' => 'I Pv6',
            'fact_time' => 'Fact Time',
            'last_report_time' => 'Last Report Time',
            'hostname' => 'Hostname',
            'state' => 'State',
            'facts' => 'Facts',
            'last_report' => 'Last Report',
            'os' => 'Os',
            'environment' => 'Environment',
            'configuration_version' => 'Configuration Version',
            'puppet_version' => 'Puppet Version',
            'status' => 'Status',
            'transaction_completed' => 'Transaction Completed',
        ];
    }
    
    public static function upsertReport($data)
    {
        if (!is_array($data) || !array_key_exists('hostname', $data)) {
            return false;
        }
        
        $host = self::find()->where(['hostname' => $data['hostname']])->one();
        
        if (!$host) {
            $host = new self();
        }
        
        $host->_parser = [];
        
        $this->parseRecursiveArray($data);
        
        return $host->_parser;
    }
    
    
    public static function upsertFactFile($data)
    {
        if (!is_array($data) || !array_key_exists('name', $data)) {
            return false;
        }
        
        $host = self::find()->where(['hostname' => $data['name']])->one();
        
        if (!$host) {
            $host = new self();
        }
        
        $host->_parser = [];
        
        $host->parseRecursiveArray($data);
        
        return $host->_parser;
    }
    
    /**
     * Recursive function to flatten array
     * 
     * @param array $data
     * @param array $keys
     */
    protected function parseRecursiveArray($data, $keys=[])
    {
        foreach($data as $key=>$value) {
            $keyOut = $keys;
            $keyOut[] = $key;
            
            if(is_array($value)) {
                $this->parseRecursiveArray($value, $keyOut);
            } else {
                $this->_parser[implode(".", $keyOut)] = $value;
            }
        }
    }
}
