<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
// use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $policies []app\models\db\Pps */
/* @var $policy  app\models\db\Pps */
/* @var $sources mixed */
/* @var $destinations mixed */
/* @var $sourcesSelected mixed */
/* @var $destinationsSelected mixed */
/* @var $applicationFilter mixed */


$this->title = "Zone Rules for " . $sources[0]['fw_name'];

//$this->params['breadcrumbs'][] = ['label' => 'Fw Configs', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php function tableHeader() {
    //    	<th>Source Zone</th>
    ?>
<table class="table table-hover table-striped"><thead>
    <tr>
    	<th>Policy Name</th>
    	<th>Destination Zone</th>
    	<th>Source Address</th>
    	<th>Destination Address</th>
    	<th>Application(s)</th>
    	<th>Action</th>
    	<th>Description</th>
    </tr>
</thead><tbody>
<?php } 
function tableFooter() {
    echo "</tbody></table>\n";
}

?>

<div class="hidden-print">
<h1><?= $this->title ?></h1>

<h2>Select Filters</h2>

<h4>Sources</h4>
<div class="well well-sm">
<?php
echo Html::beginForm();
echo Html::hiddenInput('name',$sources[0]['fw_name']);

echo Html::checkboxList('sources', $sourcesSelected, ArrayHelper::map($sources, 'source_zone', 'source_zone') );
?>
<strong>Filter: </strong> 
<?php 
echo Html::textInput('sourceFilter',$sourceFilter);
?>
</div>

<h4>Destinations</h4>
<div class="well well-sm">
<?php
echo Html::checkboxList('desintations', $destinationsSelected, ArrayHelper::map($destinations, 'destination_zone', 'destination_zone') );
?>
<strong>Filter: </strong> 
<?php 
echo Html::textInput('desintationFilter',$desintationFilter);
?>
</div>

<h4>Applications</h4>
<div class="well well-sm">
<strong>Filter: </strong> 
<?php 
echo Html::textInput('applicationFilter',$applicationFilter);
?>
</div>

<?php
echo Html::submitButton('Submit',['class'=>'btn btn-primary']);
echo Html::endForm();
?>
<h2>Zone-to-Zone Policies</h2>
</div>


<?php 
//$lastZones = $policies[0]->source_zone . ":" . $policies[0]->destination_zone;
$lastDest = '';

$lastSrc = '';

$group = [];

foreach ($policies as $policy) {
    if ($policy->source_zone == '' && $policy->destination_zone == '') {
        $group[] = $policy;
        
        continue;
    }
    
    if ($lastSrc != $policy->source_zone) {
        if ($lastDest != '') {
            tableFooter();
        }
        echo "<h3>Zone Rules for ".$sources[0]['fw_name'].", Source: ".$policy->source_zone;
        
        if ($sourceFilter) {
            echo ", Source Filter: *$sourceFilter*";
        }
        
        if ($desintationFilter) {
            echo ", Destination Filter: *$desintationFilter*";
        }
        
        if ($applicationFilter) {
            echo ", Application Filter: *$applicationFilter*";
        }
        
        echo "</h3>\n";
        tableHeader();

        $lastSrc = $policy->source_zone;
    } elseif ($lastDest != '' && $lastDest != $policy->destination_zone) {
        echo "<tr><td colspan=8 class='info'></td></tr>";
    }
    $lastDest = $policy->destination_zone;
    
    $attiribs=[
        'policy_name',
        //'source_zone',
        'destination_zone',
        'source_address',
        'destination_address',
        'application',
        'action',
        'notes',
    ];
    
    echo "<tr>";
    if (strlen($policy->application.$policy->action) == 0 && strlen($policy->notes) > 0 ) {
        echo "<td>".Html::encode($policy->policy_name)."</td>";
        echo "<td>".Html::encode($policy->destination_zone)."</td>";
        echo "<td>".Html::encode($policy->source_address)."</td>";
        echo "<td>".Html::encode($policy->destination_address)."</td>";
        echo "<td colspan='3' class='text-center'>".Html::encode($policy->notes)."</td>";
    } else {
        foreach($attiribs as $attrib) {
            echo "<td>";
            echo Html::encode($policy->$attrib);
            echo "</td>";
        }
    }
    echo "</tr>\n";
}
if ($lastDest != '') {
    tableFooter();
}
