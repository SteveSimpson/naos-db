<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "t_pps".
 *
 * @property int $id
 * @property string $fw_name
 * @property string $policy_name
 * @property string $source_zone
 * @property string $destination_zone
 * @property string $source_address
 * @property string $destination_address
 * @property string $application
 * @property string $action
 * @property string $notes
 * @property int $line
 * future? property string $source_ports
 * future? property string $destination_ports
 */
class Pps extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_pps';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notes'], 'string'],
            [['fw_name', 'policy_name', 'source_zone', 'destination_zone', 'source_address', 'destination_address', 'application', 'action'], 'string', 'max' => 255],
            [['fw_name', 'policy_name'], 'unique', 'targetAttribute' => ['fw_name', 'policy_name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fw_name' => 'Fw Name',
            'policy_name' => 'Policy Name',
            'source_zone' => 'Source Zone',
            'destination_zone' => 'Destination Zone',
            'source_address' => 'Source Address',
            'destination_address' => 'Destination Address',
            //'source_ports' => 'Source Ports',
            //'destination_ports' => 'Destination Ports',
            'application' => 'Application',
            'action' => 'Action',
            'notes' => 'Notes',
            'line' => 'Line',
        ];
    }
    
    public static function parseConfig($firewall) 
    {
        $config = FwConfig::find()->where(['fw_name'=>$firewall])->one();
        
        Pps::deleteAll(['fw_name'=>$firewall]);
        FwApp::deleteAll(['fw_name'=>$firewall]);
        FwAppSet::deleteAll(['fw_name'=>$firewall]);
        FwAddresses::deleteAll(['fw_name'=>$firewall]);
        
        // @var app\models\db\FwConfig $config
        
        if (!$config) {
            // TODO: log error
            return false;
        }
        
        $lines = explode("\n", $config->fw_config);
        
        foreach($lines as $line) {
            $words = explode(" ", $line);
            
           if ($words && count($words) > 5) {
                if ($words[0] == "set" && $words[1] == "security" && $words[5] == "address-book") {
                    self::parseAddressBook($firewall, $words);
                }
           } 
           if ($words && count($words) > 3) {
                if ($words[0] == "set" && $words[1] == "security" && $words[2] == "policies") {
                    self::parseSecurityPolicy($firewall, $words);
                }
                if ($words[0] == "set" && $words[1] == "applications" && $words[2] == "application") {
                    self::parseApplication($firewall, $words);
                }
                if ($words[0] == "set" && $words[1] == "applications" && $words[2] == "application-set") {
                    self::parseApplicationSet($firewall, $words);
                }
                if ($words[0] == "set" && $words[1] == "groups" && $words[3] == "security") {
                    self::parseGroupSecurityPolicy($firewall, $words);
                }
            }
        }
    }
    
    /**
     * 
     * @param string   $firewall
     * @param string[] $words
     */
    protected static function parseSecurityPolicy($firewall, $words)
    {
        $cline = new FwConfigLine;
        
        $cline->fullLine = $words;
        
        $cline->lastWord = '';
        $cline->lastWord2 = '';
        
        $pps = false;
        
        $quote = false;
        
        foreach($words as $wordNumber=>$word) {
            
            // DEAL WITH QUOTED PHRASES
            if(substr($word, 0,1) =='"') {
                $quote = $word;
                continue;
            }
            
            if ($quote) {
                $quote .= " " . $word;
                if (strstr($word, '"') !== false) {
                    $word = $quote;
                    $quote = false;
                } else {
                    continue;
                }
            }
            // END DEAL WITH QUOTED PHRASES
            
            /*
            if ($cline->lastWord == "apply-groups") {
                $cline->policyUniqueName =  "apply-groups." . $word;
                
                $pps = self::findSelf($firewall, $cline->policyUniqueName);
            }
            */
            
            if ($cline->lastWord == "from-zone") {
                $cline->fromZone = $word;
            }
            
            if ($cline->lastWord == "to-zone") {
                $cline->toZone = $word;
            }
            
            if ($cline->lastWord == "policy") {
                $cline->policy = $word;
            }
            
            if ($pps && $cline->lastWord2 == "match") {
                if ($cline->lastWord == "source-address") {
                    $pps->source_address = trim($pps->source_address . " " . $word);
                }
                if ($cline->lastWord == "destination-address") {
                    $pps->destination_address = trim($pps->destination_address . " " . $word);
                }
                if ($cline->lastWord == "application") {
                    $pps->application = trim($pps->application . " " . $word);
                }
            }
            
            if ($cline->policyUniqueName == "" &&  $cline->fromZone != "" && $cline->toZone != "" && $cline->policy != "") {
                $cline->policyUniqueName =  $cline->fromZone . "." . $cline->toZone . "." . $cline->policy;
                
                $pps = self::findSelf($firewall, $cline->policyUniqueName);
                $pps->source_zone = $cline->fromZone;
                $pps->destination_zone = $cline->toZone;
            }
            
            if ($pps && $cline->lastWord == "then") {
                $pps->action = trim($pps->action . " " . $word);
            }
            
            if ($pps && $cline->lastWord == "description") {
                $pps->notes = trim($pps->notes . " " . $word);
            }
            
            $cline->lastWord2 = $cline->lastWord;
            $cline->lastWord = $word;
        }
        
        if($pps) {
            
            $pps->save();
            //TODO: Add wrapper and error logger
        }
    }

    /**
     *
     * @param string   $firewall
     * @param string[] $words
     */
    protected static function parseGroupSecurityPolicy($firewall, $words)
    {
        $cline = new FwConfigLine;
        
        $cline->fullLine = $words;
        
        $cline->lastWord = '';
        $cline->lastWord2 = '';
        
        $pps = false;
        
        $quote = false;
        
        foreach($words as $wordNumber=>$word) {
            
            // DEAL WITH QUOTED PHRASES
            if(substr($word, 0,1) =='"') {
                $quote = $word;
                continue;
            }
            
            if ($quote) {
                $quote .= " " . $word;
                if (strstr($word, '"') !== false) {
                    $word = $quote;
                    $quote = false;
                } else {
                    continue;
                }
            }
            // END DEAL WITH QUOTED PHRASES
            
            if ($cline->lastWord == "policy") {
                $cline->policy = $word;
            }
            
            if ($pps && $cline->lastWord2 == "match") {
                if ($cline->lastWord == "source-address") {
                    $pps->source_address = trim($pps->source_address . " " . $word);
                }
                if ($cline->lastWord == "destination-address") {
                    $pps->destination_address = trim($pps->destination_address . " " . $word);
                }
                if ($cline->lastWord == "application") {
                    $pps->application = trim($pps->application . " " . $word);
                }
            }
            
            if ($cline->policyUniqueName == "" && $cline->policy != "") {
                $cline->policyUniqueName =  "groups." . $cline->policy;
                
                $pps = self::findSelf($firewall, $cline->policyUniqueName);
            }
            
            if ($pps && $cline->lastWord == "then") {
                $pps->action = trim($pps->action . " " . $word);
            }
            
            if ($pps && $cline->lastWord == "description") {
                $pps->notes = trim($pps->notes . " " . $word);
            }
            
            $cline->lastWord2 = $cline->lastWord;
            $cline->lastWord = $word;
        }
        
        if($pps) {
            
            $pps->save();
            //TODO: Add wrapper and error logger
        }
    }
    
    /**
     *
     * @param string   $firewall
     * @param string[] $words
     */
    protected static function parseApplication($firewall, $words)
    {
        $lastWord = '';
        
        $lastWord2 = '';
        
        $appName = false;
        
        $appLine = false;
        
        $param = false;
        
        $value = false;
        
        $detail = false;
        
        $noTerm = false;

        foreach($words as $wordNumber=>$word) {            
            
            if ($lastWord == 'application') {
                $appName = $word;
            }
            
            if ($lastWord2 == 'application' && $word != 'term') {
                $noTerm = true;
            }
            
            if ($noTerm) {
                if (! $param) {
                    $param = $word;
                    //echo "param: " . $word . "\n";
                } else {
                    $value = $word;
                    
                    $appLine = "-";
                    //echo "value: " . $word . "\n";
                }
            }
            
            if ($lastWord == 'term') {
                $appLine = $word;
            }
            
            if ($lastWord2 == 'term') {
                $param = $word;
            }
            
            if ($lastWord == $param) {
                $value = $word;
            }
            
            
            if ($lastWord == 'protocol') {
                $value = $word;
            }
            
            $lastWord2 = $lastWord;
            $lastWord = $word;
        }
        
        if($appName && $appLine && $param && $value) {
            $app = FwApp::find()->where(['fw_name'=>$firewall, 'app_name'=>$appName, 'app_line'=>$appLine])->one();
            
            if (!$app) {
                $app = new FwApp();
                $app->fw_name = $firewall;
                $app->app_name = $appName;
                $app->app_line = $appLine;
            }
            
            switch ($param) {
                case 'protocol':
                    $app->protocol .= trim($app->protocol . " " . $value);
                    break;
                case 'source-port':
                    $app->source_port .= trim($app->source_port . " " . $value);
                    break;
                case 'destination-port':
                    $app->destination_port .= trim($app->destination_port . " " . $value);
                    break;
                default:
                    $app->inactivity_timeout .= trim($app->inactivity_timeout . ", " . $param . ": " .$value, ", ");
                    break;
            }
            
            // WRAP & LOG Error
            $app->save();
        }
    }
    
    /**
     *
     * set applications application-set good-icmp6-and-traceroute application cust-icmp6-time-exceed-transi
     * set applications application-set good-icmp6-and-traceroute application-set cust-junos-traceroute
     * 
     * @param string   $firewall
     * @param string[] $words
     */
    protected static function parseApplicationSet($firewall, $words)
    {
        if (is_array($words) && count($words) >= 6) {
            $app = new FwAppSet();
            
            $app->fw_name = $firewall;
            $app->app_set_name = $words[3];
            $app->app_sub_type = $words[4];
            $app->app_sub_name = $words[5];
            
            // WRAP & LOG Error
            $app->save();
        }
    }
    
    /**
     *
     * @param string   $firewall
     * @param string[] $words
     */
    protected static function parseAddressBook($firewall, $words)
    {
        if (is_array($words) && count($words) >= 9) {
            
            if($words[6] == 'address-set') {
                $app = FwAddresses::find()->where(['fw_name'=>$firewall,'fw_zone'=>$words[4],'name'=>$words[7]])->one();
                
                if (!$app) {
                    $app = new FwAddresses();
                    
                    $app->fw_name = $firewall;
                    $app->fw_zone = $words[4];
                    $app->name = $words[7];
                }
                $app->ip = trim($app->ip . " " . $words[9]);
            } else {
                $app = new FwAddresses();
                
                $app->fw_name = $firewall;
                $app->fw_zone = $words[4];
                $app->name = $words[7];
                $app->ip = $words[8];
            }
            // WRAP & LOG Error
            $app->save();
        }
    }
    
    protected static function findSelf($firewall, $policy)
    {
        $pps = self::find()->where(['fw_name'=>$firewall, 'policy_name'=>$policy])->one();
        
        if(!$pps) {
            $pps = new self;
            
            $line=self::find()->where(['fw_name'=>$firewall])->max('line');
            
            $pps->line = $line + 1;
            
            $pps->fw_name = $firewall;
            
            $pps->policy_name = $policy;
        }
        
        return $pps;
    }
}
