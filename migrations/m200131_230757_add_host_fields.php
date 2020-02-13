<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200131_230757_add_host_fields
 */
class m200131_230757_add_host_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('t_location', 'building', Schema::TYPE_STRING);

        $this->addColumn('t_network', 'vlan', Schema::TYPE_STRING);
        
        $this->addColumn('t_host', 'os_id', Schema::TYPE_INTEGER);
        $this->addColumn('t_host', 'virtual', Schema::TYPE_TINYINT);
        $this->addColumn('t_host', 'make', Schema::TYPE_STRING);
        $this->addColumn('t_host', 'model', Schema::TYPE_STRING);
        $this->addColumn('t_host', 'serial', Schema::TYPE_STRING);
        $this->addColumn('t_host', 'dod_approval', Schema::TYPE_TINYINT);
        $this->addColumn('t_host', 'critical', Schema::TYPE_TINYINT);
        $this->addColumn('t_host', 'hw_show', Schema::TYPE_TINYINT);
        
        $this->createTable('t_os', [
            'id' => Schema::TYPE_PK,
            'os_name_version' => Schema::TYPE_STRING,
            'os_stig' => Schema::TYPE_STRING,
            'notes' => Schema::TYPE_TEXT,
        ]);
        
        $this->createIndex('os_name_version_idx', 't_os', ['os_name_version'], true);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('os_name_version_idx', 't_os');
        
        $this->dropTable('t_os');
        
        // $this->dropColumn('t_host', 'os_id' ... 'critical');
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
            'ipv4int' => Schema::TYPE_BIGINT,
        ]);
        
        $this->createIndex('hostname_idx', 't_host', ['hostname'], true);
        $this->createIndex('fqdn_idx', 't_host', ['fqdn'], true);
        
        $sql = "INSERT INTO t_host SELECT id, hostname, fqdn, network_name, location_name, service, ipv4, ipv6, mask4, mask6, monitor_ip, enabled, notes, type, ipv4int FROM t_host_temp";
        $this->execute($sql);
        $this->dropTable('t_host_temp');
        
        // $this->dropColumn('t_network', 'vlan');
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
            'range4' => Schema::TYPE_STRING,
        ]);
        
        $this->createIndex('network_name_idx', 't_network', ['network_name'], true);

        $sql = "INSERT INTO t_network SELECT id, network_name, location_name, prefix4, prefix6, mask4, mask6, dnsdomain, notes, range4 FROM t_network_temp";
        $this->execute($sql);
        $this->dropTable('t_network_temp');
        
        // $this->dropColumn('t_location', 'building');
        $this->dropIndex('location_name_idx', 't_location');
        $this->renameTable('t_location', 't_location_temp');
        $this->createTable('t_location', [
            'id' => Schema::TYPE_PK,
            'location_name' => Schema::TYPE_STRING,
            'notes' => Schema::TYPE_TEXT,
        ]);
        
        $this->createIndex('location_name_idx', 't_location', ['location_name'], true);
        
        $sql = "INSERT INTO t_location SELECT id, location_name, notes FROM t_location_temp";
        $this->execute($sql);
        $this->dropTable('t_location_temp');
    }
}
