<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_location".
 *
 * @property int $id
 * @property string $location_name
 * @property string $notes
 */
class Location extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notes'], 'string'],
            [['location_name'], 'string', 'max' => 255],
            [['location_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location_name' => 'Location Name',
            'notes' => 'Notes',
        ];
    }
}
