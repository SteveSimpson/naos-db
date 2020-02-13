<?php
/**
 * Views under host & network should be the same other than links
 * Update both at the same time
 */


use yii\helpers\Html;
// use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $hosts app\models\db\Host[] */

$this->title = "Network Diagram Host List";
if ($html){
    
    $this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['location/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Networks', 'url' => ['network/index']];
    $this->params['breadcrumbs'][] = $this->title;
    $this->params['breadcrumbs'][] = date("Y-m-d H:i:s");
    $this->params['breadcrumbs'][] = ['label' => 'Export', 'url' => ['hw-list', 'format'=>'tab']];
}

$fields = [
    "Line",
    "Machine Name",
    "Component Type",
    "Make Model SN",
    "OS Version",
    "IPv4",
    "IPv6",
];

// set the default
$separator = ";";

if($format=="tab") {
    $separator = "\t";
}

// init the network_name to false
$networkName = false;
$tableOpen = false;

$count = 1;

foreach($hosts as $host) {
    if($host->os == null || $host->location == null) {
        continue;
    }
    
    if ($networkName !== $host->network_name) {
        $networkName = $host->network_name;
        
        if ($html) {
            if ($tableOpen) {
                echo "</tbody></table>\n";
            }
            
            echo "<h4>";
            echo $networkName . ", VLAN: " . $host->network->vlan . ", DNS Zone: " . $host->network->dnsdomain;
            echo "</h4>\n";
            
            $tableOpen = true;
            
            echo '<table class="table table-hover table-striped"><thead>';
            echo "<tr>";
            foreach ($fields as $field) {
                echo "<th>" . $field . "</th>";
            }
            echo "</tr></thead><tbody>\n";
        } else {
            echo $networkName . ", VLAN: " . $host->network->vlan . ", DNS Zone: " . $host->network->dnsdomain;
            echo implode($separator, $fields) . "\n";
        }
    }
    
    echo ($html ? "<tr><td>" : "");
    echo $count++;
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($host->hostname);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($host::listTypes()[$host->type]);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($host->make ." ". $host->model . " " . $host->serial);
    echo ($host->virtual ? " virtual " : "");

    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($host->os->os_name_version);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($host->ipv4);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($host->ipv6);
    
    echo ($html ? "</td></tr>\n" : "\n");
}

if($html && $tableOpen) {
    echo "</tbody></table>\n";
} 
?>
