<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m191119_172128_addNetRange
 */
class m191119_172128_addNetRange extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('t_network', 'range4', Schema::TYPE_STRING);
        
        $this->addColumn('t_host', 'ipv4int', Schema::TYPE_BIGINT);
        
        $this->createTable('t_config', [
            'name' => Schema::TYPE_STRING,
            'value' => Schema::TYPE_TEXT,
            'PRIMARY KEY (name)',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // $this->dropColumn('t_network', 'range4');
        $this->dropIndex('network_name_idx', 't_network');
        $this->renameTable('t_network', 't_network_temp');
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

        $sql = "INSERT INTO t_network SELECT id, network_name, location_name, prefix4, prefix6, mask4, mask6, dnsdomain, notes FROM t_network_temp";
        $this->execute($sql);
        $this->dropTable('t_network_temp');
        
        // $this->dropColumn('t_host', 'ipv4int');
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
            'type' => Schema::TYPE_STRING,
        ]);
        
        $this->createIndex('hostname_idx', 't_host', ['hostname'], true);
        $this->createIndex('fqdn_idx', 't_host', ['fqdn'], true);
        
        $sql = "INSERT INTO t_host SELECT id, hostname, fqdn, network_name, location_name, service, ipv4, ipv6, mask4, mask6, monitor_ip, enabled, notes, type FROM t_host_temp";
        $this->execute($sql);
        $this->dropTable('t_host_temp');
        
        $this->dropTable('t_config');
    }
}
