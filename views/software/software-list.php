<?php

use yii\helpers\Html;
// use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $apps app\models\db\Software[] */

$this->title = "Software List";
if ($html){
    $this->params['breadcrumbs'][] = ['label' => 'Software', 'url' => ['software/index']];
    $this->params['breadcrumbs'][] = $this->title;
    $this->params['breadcrumbs'][] = date("Y-m-d H:i:s");
    $this->params['breadcrumbs'][] = ['label' => 'Export', 'url' => ['software-list', 'format'=>'tab']];
}

$fields = [
    "Line",
    "Software Type",
    "Software Name",
    "Version",
    "Manufacturer",
    "License Type",
    "Total Licenses",
    "Licenses Used",
    "DoD Approval",
    "Critical Asset",
    "STIG Name",
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

foreach($apps as $app) {
    echo ($html ? "<tr><td>" : "");
    echo $count++;
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($app->type);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($app->name);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($app->version);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($app->manufacturer);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($app->license_or_contract);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($app->licenses_total);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($app->licenses_used);
    
    echo ($html ? "</td><td>" : $separator);
    echo Html::encode($app->dod_approval);
    
    echo ($html ? "</td><td>" : $separator);
    echo ($app->critical ? "Yes" : "No");
    
    echo ($html ? "</td><td>" : $separator);
    if (strlen($app->stig) > 0) {
        echo Html::encode($app->stig);
    } else {
        echo "No applicable STIG";
    }
    
    echo ($html ? "</td></tr>\n" : "\n");
}

if($html) { ?>

	</tbody></table>

<?php } ?>
