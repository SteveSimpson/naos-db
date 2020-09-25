<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Nagios extends Model
{
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            //[['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            //['email', 'email'],
            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha'],
        ];
    }
    
    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            //'verifyCode' => 'Verification Code',
        ];
    }
    
    public static function menuItems()
    {
        return [
            'Current Status' => [
                ['Tactical Overview'=>'/nagios/cgi-bin/tac.cgi'],
                ['Hosts'=>'/nagios/cgi-bin/status.cgi?hostgroup=all&amp;style=hostdetail'],
                ['Services'=>'/nagios/cgi-bin/status.cgi?host=all'],
                ['Host Groups'=>'/nagios/cgi-bin/status.cgi?hostgroup=all&amp;style=overview'],
                ['Service Groups'=>'/nagios/cgi-bin/status.cgi?servicegroup=all&amp;style=overview'],
                ['Host Problems'=>'/nagios/cgi-bin/status.cgi?hostgroup=all&amp;style=hostdetail&amp;hoststatustypes=12'],
                ['Service Problems'=>'/nagios/cgi-bin/status.cgi?host=all&amp;servicestatustypes=28'],
                ['Map'=>'/nagios/map.php?host=all','(Legacy)'=>'/nagios/cgi-bin/statusmap.cgi?host=all'],
                ['Network Outages'=>'/nagios/cgi-bin/outages.cgi'],
            ],
            'Reports' => [
                ['Availability'=>'/nagios/cgi-bin/avail.cgi'],
                ['Trends'=>'/nagios/trends.html', '(Legacy)'=>'/nagios/cgi-bin/trends.cgi'],
                ['Alert History'=>'/nagios/cgi-bin/history.cgi?host=all'],
                ['Alert Summary'=>'/nagios/cgi-bin/summary.cgi'],
                ['Alert Histogram'=>'/nagios/histogram.html', '(Legacy)'=>'/nagios/cgi-bin/histogram.cgi'],
                ['Notifications'=>'/nagios/cgi-bin/notifications.cgi?contact=all'],
                ['Event Log'=>'/nagios/cgi-bin/showlog.cgi'],
            ],
            'System' => [
                ['Comments'=>'/nagios/cgi-bin/extinfo.cgi?type=3'],
                ['Downtime'=>'/nagios/cgi-bin/extinfo.cgi?type=6'],
                ['Process Info'=>'/nagios/cgi-bin/extinfo.cgi?type=0'],
                ['Performance Info'=>'/nagios/cgi-bin/extinfo.cgi?type=4'],
                ['Scheduling Queue'=>'/nagios/cgi-bin/extinfo.cgi?type=7'],
                ['Configuration'=>'/nagios/cgi-bin/config.cgi'],
            ],
            'Naos' => [
                ['Locations'=>'/nagios/naos.php?r=location'],
                ['Networks'=>'/nagios/naos.php?r=network'],
                ['Hosts'=>'/nagios/naos.php?r=host'],
                ['Software'=>'/nagios/naos.php?r=software'],
                ['FW Configs'=>'/nagios/naos.php?r=pps'],
                ['Naos Configs'=>'/nagios/naos.php?r=config'],
            ],
        ];
    }
    
    /**
     * TODO - this should have a table with maintenance, but this is a lot faster
     * 
     * @return array
     */
    public static function serviceMatchList()
    {
        return [
            'Application',
            'Cert',
            'CRLs',
            'DNS',
            'Drive',
            'FIPS',
            'HTTP',
            'Load',
            'Memory',
            'Partition',
            'Postfix',
            'Puppet',
            'SELinux',
            'SSH',
            'Swap',
            'Updates',
        ];
        
    }
}