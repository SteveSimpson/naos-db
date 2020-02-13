<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_os".
 *
 * @property int $id
 * @property string $os_name_version
 * @property string $os_stig
 * @property string $notes
 */
class Os extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_os';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notes'], 'string'],
            [['os_name_version', 'os_stig'], 'string', 'max' => 255],
            [['os_name_version'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'os_name_version' => 'OS Name/Version',
            'os_stig' => 'OS Stig',
            'notes' => 'Notes',
        ];
    }
}
