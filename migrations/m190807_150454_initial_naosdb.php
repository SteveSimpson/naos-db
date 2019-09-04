<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190807_150454_initial_naosdb
 */
class m190807_150454_initial_naosdb extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('t_location', [
            'id' => Schema::TYPE_PK,
            'location_name' => Schema::TYPE_STRING,
            'notes' => Schema::TYPE_TEXT,
        ]);
        
        $this->createIndex('location_name_idx', 't_location', ['location_name'], true);
        
        $this->createTable('t_network', [
            'id' => Schema::TYPE_PK,
            'network_name' => Schema::TYPE_STRING,
            'location_name' => Schema::TYPE_STRING,
            'prefix4' => Schema::TYPE_STRING,
            'prefix6' => Schema::TYPE_STRING,
            'mask4' => Schema::TYPE_STRING,
            'mask6' => Schema::TYPE_STRING,
            'dnsdomain' => Schema::TYPE_STRING,
            'notes' => Schema::TYPE_TEXT,
        ]);
        
        $this->createIndex('network_name_idx', 't_network', ['network_name'], true);
        
        $this->createTable('t_host', [
            'id' => Schema::TYPE_PK,
            'hostname'=> Schema::TYPE_STRING,
            'fqdn' => Schema::TYPE_STRING,
            'network_name' => Schema::TYPE_STRING,
            'location_name' => Schema::TYPE_STRING,
            'service' => Schema::TYPE_STRING,
            'ipv4' => Schema::TYPE_STRING,
            'ipv6' => Schema::TYPE_STRING,
            'mask4' => Schema::TYPE_STRING,
            'mask6' => Schema::TYPE_STRING,
            'monitor_ip' => Schema::TYPE_STRING,
            'enabled' => Schema::TYPE_TINYINT,
            'notes' => Schema::TYPE_TEXT,
        ]);
        
        $this->createIndex('hostname_idx', 't_host', ['hostname'], true);
        
        $this->createIndex('fqdn_idx', 't_host', ['fqdn'], true);
        
        $this->createTable('t_fw_config', [
            'id' => Schema::TYPE_PK,
            'fw_name' => Schema::TYPE_STRING,
            'fw_type' => Schema::TYPE_STRING,
            'notes' => Schema::TYPE_TEXT,
        ]);
        
        $this->createIndex('fw_name_idx', 't_fw_config', ['fw_name'], true);
        
        $this->createTable('t_pps', [
            'id' => Schema::TYPE_PK,
            'fw_name' => Schema::TYPE_STRING,
            'policy_name' => Schema::TYPE_STRING,
            'source_zone' => Schema::TYPE_STRING,
            'destination_zone' => Schema::TYPE_STRING,
            'source_address' => Schema::TYPE_STRING,
            'destination_address' => Schema::TYPE_STRING,
            'application' => Schema::TYPE_STRING,
            'action' => Schema::TYPE_STRING,
            'notes' => Schema::TYPE_TEXT,
        ]);
        
        $this->createIndex('fw_policy_idx', 't_pps', ['fw_name', 'policy_name'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tables = ['t_location', 't_network', 't_host', 't_fw_config', 't_pps'];
        
        foreach ($tables as $table) {
            $this->dropTable($table);
        }
    }
}
