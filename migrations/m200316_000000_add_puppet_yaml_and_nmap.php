<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200316_000000_add_puppet_yaml_and_nmap
 * 
 * https://nmap.org/book/output-formats-xml-output.html
 */
class m200316_000000_add_puppet_yaml_and_nmap extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('t_nmap_scan', [
            'id' => Schema::TYPE_PK,
            'args' => Schema::TYPE_STRING,
            'start' => Schema::TYPE_BIGINT,
            'version' => Schema::TYPE_STRING,
            'finish' => Schema::TYPE_BIGINT,
            'summary' => Schema::TYPE_STRING,
            'exit' => Schema::TYPE_STRING,
            'hosts_up'  => Schema::TYPE_INTEGER,
            'hosts_down'  => Schema::TYPE_INTEGER,
        ]);
        
        $this->createTable('t_nmap_host', [
            'id' => Schema::TYPE_PK,
            'IPv4' => Schema::TYPE_STRING,
            'IPv6' => Schema::TYPE_STRING,
            'starttime' => Schema::TYPE_BIGINT,
            'stoptime' => Schema::TYPE_BIGINT,
            'hostname' => Schema::TYPE_STRING,
            'state' => Schema::TYPE_STRING,
            'state_reason' => Schema::TYPE_STRING,
            'os' => Schema::TYPE_STRING,
            'os_percent' => Schema::TYPE_INTEGER,
            'uptime_seconds' => Schema::TYPE_INTEGER,
            'uptime_lastboot' => Schema::TYPE_STRING,
            'tcpsequence_difficulty' => Schema::TYPE_STRING,
            'last_scan_id' => Schema::TYPE_INTEGER,
        ]);
        
        $this->createIndex('nmap_host_ip', 't_nmap_host', ['IPv4', 'IPv6'], true);
        $this->createIndex('nmap_hostname', 't_nmap_host', ['hostname'], false);
        
        $this->createTable('t_nmap_hostname', [
            'id' => Schema::TYPE_PK,
            'host_id' => Schema::TYPE_INTEGER,
            'hostname' => Schema::TYPE_STRING,
            'type' => Schema::TYPE_STRING,
        ]);
        
        $this->createIndex('nmap_hostname_hostname', 't_nmap_hostname', ['hostname'], false);
        
        $this->createTable('t_nmap_port', [
            'id' => Schema::TYPE_PK,
            'host_id' => Schema::TYPE_INTEGER,
            'port' => Schema::TYPE_INTEGER,
            'protocol' => Schema::TYPE_STRING,
            'state' => Schema::TYPE_STRING,
            'state_reason' => Schema::TYPE_STRING,
            'state_reason_ttl' => Schema::TYPE_INTEGER,
            'service_name' =>  Schema::TYPE_STRING,
            'service_product' =>  Schema::TYPE_STRING,
            'service_version' =>  Schema::TYPE_STRING,
            'service_extrainfo' =>  Schema::TYPE_STRING,
            'service_method' =>  Schema::TYPE_STRING,
            'service_conf' =>  Schema::TYPE_STRING,
            'cpe' => Schema::TYPE_TEXT,
            'scripts' => Schema::TYPE_TEXT,
        ]);
        
        $this->createIndex('nmap_host_port', 't_nmap_port', ['host_id', 'port', 'protocol'], true);
        
        $this->createTable('t_nmap_port_info', [
            'id' => Schema::TYPE_PK,
            'host_id' => Schema::TYPE_INTEGER,
            'port_id' => Schema::TYPE_INTEGER,
            'type' =>  Schema::TYPE_STRING,
            'id' =>  Schema::TYPE_STRING,
            'text' => Schema::TYPE_TEXT,
        ]);
        
        $this->createIndex('nmap_host_port_info', 't_nmap_port_info', ['host_id', 'port_id'], true);
        
        $this->createTable('t_puppet_host', [
            'id' => Schema::TYPE_PK,
            'IPv4' => Schema::TYPE_STRING,
            'IPv6' => Schema::TYPE_STRING,
            'fact_time' => Schema::TYPE_BIGINT,
            'last_report_time' => Schema::TYPE_BIGINT,
            'hostname' => Schema::TYPE_STRING,
            'state' => Schema::TYPE_STRING,
            'facts' => Schema::TYPE_TEXT,
            'last_report' => Schema::TYPE_TEXT,
            'os' => Schema::TYPE_STRING,
            'environment' => Schema::TYPE_STRING,
            'configuration_version' => Schema::TYPE_STRING,
            'puppet_version' => Schema::TYPE_STRING,
            'status' => Schema::TYPE_STRING,
            'transaction_completed' => Schema::TYPE_STRING,
        ]);
        
        $this->createIndex('puppet_host', 't_puppet_host', ['hostname'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tables = [
            't_puppet_host',
            't_nmap_port_info',
            't_nmap_port',
            't_nmap_hostname',
            't_nmap_host',
            't_nmap_scan',
        ];

        foreach ($tables as $table) {
            $this->dropTable($table);
        }
    }
}
