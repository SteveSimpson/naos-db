<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190807_204724_initialTweaks
 */
class m190807_204724_initialTweaks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('t_host', 'type', Schema::TYPE_STRING);
        
        $this->addColumn('t_fw_config', 'fw_config', Schema::TYPE_TEXT);
        
        $this->addColumn('t_pps', 'line', Schema::TYPE_INTEGER);
        
        $this->createTable('t_fw_app', [
            'id' => Schema::TYPE_PK,
            'fw_name' => Schema::TYPE_STRING,
            'app_name' => Schema::TYPE_STRING,
            'app_line' => Schema::TYPE_STRING,
            'protocol' => Schema::TYPE_STRING,
            'source_port' => Schema::TYPE_STRING,
            'destination_port' => Schema::TYPE_STRING,
            'inactivity_timeout' => Schema::TYPE_STRING,
        ]);
        
        $this->createIndex('fw_app_idx', 't_fw_app', ['fw_name', 'app_name', 'app_line'], true);
        
        $this->createTable('t_fw_app_set', [
            'id' => Schema::TYPE_PK,
            'fw_name' => Schema::TYPE_STRING,
            'app_set_name' => Schema::TYPE_STRING,
            'app_sub_type' => Schema::TYPE_STRING,
            'app_sub_name' => Schema::TYPE_STRING,
        ]);
        
        $this->createIndex('fw_app_set_idx', 't_fw_app_set', ['fw_name', 'app_set_name', 'app_sub_name'], true);
        
        $this->createTable('t_fw_addresses', [
            'id' => Schema::TYPE_PK,
            'fw_name' => Schema::TYPE_STRING,
            'fw_zone' => Schema::TYPE_STRING,
            'name' => Schema::TYPE_STRING,
            'ip' => Schema::TYPE_STRING,
        ]);
        
        $this->createIndex('fw_addresses_idx', 't_fw_addresses', ['fw_name', 'fw_zone', 'name'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        //$this->dropColumn('t_host', 'type'); - doesn't work with sqlite :'(
        $this->dropIndex('hostname_idx', 't_host');
        $this->dropIndex('fqdn_idx', 't_host');
        
        $this->renameTable('t_host', 't_host_temp');
        
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
        
        $sql = "INSERT INTO t_host SELECT id, hostname, fqdn, network_name, location_name, service, ipv4, ipv6, mask4, mask6, monitor_ip, enabled, notes FROM t_host_temp";
        $this->execute($sql);
        $this->dropTable('t_host_temp');
        
        
        //$this->dropColumn('t_fw_config', 'fw_config'); - doesn't work with sqlite :'(
        $this->dropIndex('fw_name_idx', 't_fw_config');
        $this->renameTable('t_fw_config', 't_fw_config_temp');
        
        $this->createTable('t_fw_config', [
            'id' => Schema::TYPE_PK,
            'fw_name' => Schema::TYPE_STRING,
            'fw_type' => Schema::TYPE_STRING,
            'notes' => Schema::TYPE_TEXT,
        ]);
        
        $this->createIndex('fw_name_idx', 't_fw_config', ['fw_name'], true);
        $sql = "INSERT INTO t_fw_config SELECT id, fw_name, fw_type, notes FROM t_fw_config_temp";
        $this->execute($sql);
        $this->dropTable('t_fw_config_temp');

        $this->dropIndex('fw_policy_idx', 't_pps');
        $this->dropTable('t_pps');
        
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
        
        $this->dropTable('t_fw_app');
        
        $this->dropTable('t_fw_app_set');
        
        $this->dropTable('t_fw_addresses');
    }
}
