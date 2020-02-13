<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_software".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $version
 * @property string $manufacturer
 * @property string $license_or_contract
 * @property int $licenses_total
 * @property int $licenses_used
 * @property string $dod_approval
 * @property int $critical
 * @property string $stig
 * @property string $hosts_os_notes
 * @property string $support_links
 * @property string $other_notes
 */
class Software extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_software';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['licenses_total', 'licenses_used', 'critical', 'id'], 'integer'],
            [['hosts_os_notes', 'support_links', 'other_notes'], 'string'],
            [['name', 'type', 'version', 'manufacturer', 'license_or_contract', 'dod_approval', 'stig'], 'string', 'max' => 255],
            [['name', 'version'], 'unique', 'targetAttribute' => ['name', 'version']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'version' => 'Version',
            'manufacturer' => 'Manufacturer',
            'license_or_contract' => 'License Type',
            'licenses_total' => 'Licenses Total',
            'licenses_used' => 'Licenses Used',
            'dod_approval' => 'DoD Approval',
            'critical' => 'Critical',
            'stig' => 'STIG Name',
            'hosts_os_notes' => 'Hosts OS Notes',
            'support_links' => 'Support Links',
            'other_notes' => 'Other Notes',
        ];
    }
    
    public static function listTypes()
    {   
        $types = [
            'COTS Application' => 'COTS Application',
            'GOTS Application' => 'GOTS Application',
            'Office Automation' => 'Office Automation',
            'Other' => 'Other',
            'Security Application' => 'Security Application',
            'Server Application' => 'Server Application',
            'Web Application' => 'Web Application',
        ];
        if (array_key_exists('software_types', Yii::$app->params) && is_array(Yii::$app->params['software_types'])) {
            $types = [];
            foreach(Yii::$app->params['software_types'] as $type) {
                $types[$type] = $type;
            }
        } 
        return $types;
    }
    
    public static function listApprovalStatus()
    {
        return [
            ''=>'',
            'Approved - DISA UC APL'=>'Approved - DISA UC APL',
            'Approved - FIPS 140-2'=>'Approved - FIPS 140-2',
            'Approved - NIAP CCVES'=>'Approved - NIAP CCVES',
            'Approved - NSA Crypto'=>'Approved - NSA Crypto',
            'Approved - NSA CSfC'=>'Approved - NSA CSfC',
            'In Progress'=>'In Progress',
            'N.A.'=>'N.A.',
            'Unapproved'=>'Unapproved',
        ];
    }
}
