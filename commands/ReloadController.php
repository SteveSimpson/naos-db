<?php
/**
 * @link 
 * @copyright 
 * @license 
 */

namespace app\commands;

use app\models\db\Host;
use app\models\db\Pps;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\db\Network;

/**
 *
 */
class ReloadController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
        echo "Usage:\n";

        return ExitCode::OK;
    }
    
    public function actionHosts()
    {
        $nagHostDir = "/etc/nagios/hosts";
        $params = \Yii::$app->params;
        
        if(isset($params['nagHostDir'])) {
            $nagHostDir = $params['nagHostDir'];
        }
        
        // 1. Archice everything from /etc/nagios/hosts/
        $files = glob($nagHostDir . "/*.cfg");
        
        foreach ($files as $file) {
            rename($file, $file . ".bak");
        }
        
        // 2. Write Host files in /etc/nagios/hosts/
        $hosts = Host::find()->where(['enabled'=>1])->all();
        
        foreach ($hosts as $host) {
            $config  = "define host {\n";
            $config .= "   use                     " . $host->type . "\n";
            $config .= "   host_name               " . $host->hostname . "\n";
            $config .= "   alias                   " . $host->fqdn . "\n";
            $config .= "   address                 " . $host->monitor_ip . "\n";
            $config .= "}\n";
            
            $filename = $nagHostDir ."/".$host->hostname .".cfg";
            
            echo "Writing: $filename \n";
            
            file_put_contents($filename, $config);
        }
    }
    
    public function actionGroups()
    {
        $nagGroupDir = "/etc/nagios/hosts";
        $params = \Yii::$app->params;
        
        if(isset($params['nagGroupDir'])) {
            $nagGroupDir = $params['nagGroupDir'];
        }
        
        // 1. Archice everything from /etc/nagios/hosts/
        $files = glob($nagGroupDir . "/*.cfg");
        
        foreach ($files as $file) {
            rename($file, $file . ".bak");
        }
        
        // 2. Write Group files in /etc/nagios/groups/
        
        $nets = Network::find()->where(['>','mask4',0])->all();
        
        $hosts = Host::find()->where(['enabled'=>1])->all();
        
        foreach ($nets as $net) {
            $hosts = Host::find()->where(['enabled'=>1])->andWhere(['network_name'=>$net->network_name])->select(['hostname'])->all();
            if(is_array($hosts) && count($hosts)) {
                $hostList = [];
                foreach($hosts as $host) {
                    $hostList[]=$host->hostname;
                }
                
                $config  = "define hostgroup {\n";
                $config .= "   hostgroup_name  " . $net->dnsdomain . "\n";
                $config .= "   alias           " . $net->network_name . "\n";
                $config .= "   members         " . implode(",",$hostList) . "\n";
                $config .= "}\n";
                
                $filename = $nagGroupDir ."/".$net->dnsdomain .".cfg";
                
                echo "Writing: $filename \n";
                
                file_put_contents($filename, $config);
            }
        }
    }
    
    public function actionFixHosts()
    {
        $hosts = Host::find()->all();
        
        foreach ($hosts as $host) {
            $host->ipv4int = 1;
            $host->save();
        }
    }
    
    public function actionPps($firewall)
    {
        Pps::parseConfig($firewall);
    }
}