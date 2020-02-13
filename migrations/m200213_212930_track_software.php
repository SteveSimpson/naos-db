<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200213_212930_track_software
 */
class m200213_212930_track_software extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('t_software', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
            'type' => Schema::TYPE_STRING,
            'version' => Schema::TYPE_STRING,
            'manufacturer' => Schema::TYPE_STRING,
            'license_or_contract' => Schema::TYPE_STRING,
            'licenses_total' => Schema::TYPE_INTEGER,
            'licenses_used' => Schema::TYPE_INTEGER,
            'dod_approval' => Schema::TYPE_STRING,
            'critical' => Schema::TYPE_TINYINT,
            'stig' => Schema::TYPE_STRING,
            'hosts_os_notes' => Schema::TYPE_TEXT,
            'support_links' => Schema::TYPE_TEXT,
            'other_notes' => Schema::TYPE_TEXT,
        ]);
        
        $this->createIndex('software_version_idx', 't_software', ['name', 'version'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('t_software');
    }
}
