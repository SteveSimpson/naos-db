<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_dns_cname".
 *
 * @property int $id
 * @property string $domain
 * @property string $cname
 * @property string $target
 */
class DnsCname extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_dns_cname';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain', 'cname', 'target'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain' => 'Domain',
            'cname' => 'CName',
            'target' => 'Target',
        ];
    }
}
