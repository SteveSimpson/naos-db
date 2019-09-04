<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190813_183024_dns
 */
class m190813_183024_dns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('t_dns_cname', [
            'id'     => Schema::TYPE_PK,
            'domain' => Schema::TYPE_STRING,
            'cname'  => Schema::TYPE_STRING,
            'target' => Schema::TYPE_STRING,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('t_dns_cname');
    }
}
