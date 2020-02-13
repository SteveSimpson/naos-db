<?php

use yii\helpers\Html;
// use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $hosts app\models\db\Host[] */

$this->title = "Hardware List";
if ($html){
    $this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['location/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Networks', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['host/index']];
    $this->params['breadcrumbs'][] = $this->title;
    $this->params['breadcrumbs'][] = date("Y-m-d H:i:s");
    $this->params['breadcrumbs'][] = ['label' => 'Export', 'url' => ['hw-list', 'format'=>'tab']];
}

$fields = [
    "Line",
    "Component Type",
    "Machine Name",
    "Virtual Asset",
    "Manufacturer",
    "Model Number",
    "Serial Number",
    "OS / Version",
    "Location",
    "DoD Approval",
    "Critical Asset",
    "STIG",
];

// set the default
$separator = ";";

if($format=="tab") {
    $separator = "\t";
}
if($html) { ?>
    <table class="table table-hover table-striped"><thead>
        <tr>
        <?php 
        foreach ($fields as $field) {
            echo "<th>" . $field . "</th>";
        }
        ?>
        </tr>
    </thead><tbody>
<?php } else { 
    echo implode($separator, $fields) . "\n";
} 
$count = 1;

foreach($hosts as $host) {
    if($host->os == null || $host->location == null) {
        continue;
    }
    
    echo ($html ? "<tr><td>" : "");
    echo $count++;
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($host::listTypes()[$host->type]);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($host->hostname);
    
    echo ($html ? "</td><td>" : $separator);
    echo ($host->virtual ? "Yes" : "No");
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($host->make);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($host->model);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($host->serial);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($host->os->os_name_version);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($host->location->building);
    
    echo ($html ? "</td><td>" : $separator);
    echo ($host->dod_approval ? "Yes" : "No");
    
    echo ($html ? "</td><td>" : $separator);
    echo ($host->critical ? "Yes" : "No");
    
    echo ($html ? "</td><td>" : $separator);
    if (strlen($host->os->os_stig) > 0) {
        echo Html::encode($host->os->os_stig);
    } else {
        echo "No applicable STIG";
    }
    
    echo ($html ? "</td></tr>\n" : "\n");
}

if($html) { ?>

	</tbody></table>

<?php } ?>
