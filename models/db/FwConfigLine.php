<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_fw_config".
 *
 */
class FwConfigLine
{
    /**
     * 
     * @var [] array of words
     */
    public $fullLine;
    
    public $iteration;
    
    public $lastWord;
    
    public $lastWord2;
    
    public $fromZone;
    
    public $toZone;
    
    /**
     * policy name/number 
     *   or
     *  policies
     * 
     * @var string
     */
    public $policy;
    
    
    
    /**
     * This is made by combining unique information to make the unquie (for a firewall) name
     * - fromZone.toZone.policy
     * 
     * @var string
     */
    public $policyUniqueName;
}