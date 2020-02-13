<?php

use yii\helpers\Html;
// use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $policies []app\models\db\Pps */
/* @var $policy  app\models\db\Pps */

$this->title = "Ports, Protocols and Service Rules for " . $policies[0]->fw_name;

//$this->params['breadcrumbs'][] = ['label' => 'Fw Configs', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<h1><?= $this->title ?></h1>


<h2>Zone-to-Zone Policies</h2>
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
        echo "<h3>Source Zone: ".$policy->source_zone."</h3>\n";
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

if (count($group)) {
?>
<h3>Policy Groups</h3>

<table class="table table-hover table-striped"><thead>
    <tr>
    	<th>Policy Name</th>
    	<th>Source Address</th>
    	<th>Destination Address</th>
    	<th>Application(s)</th>
    	<th>Action</th>
    	<th>Description</th>
    </tr>
</thead><tbody>
<?php
$attiribs=[
    'policy_name',
    //'source_zone',
    //'destination_zone',
    'source_address',
    'destination_address',
    'application',
    'action',
    'notes',
];

foreach ($group as $policy) {
    echo "<tr>";
    
    foreach($attiribs as $attrib) {
        echo "<td>";
        echo Html::encode($policy->$attrib);
        echo "</td>";
    }
    echo "</tr>\n";
}
?>
</tbody></table>
<?php }?>


<h2>Applications</h2>

<?php 
if(is_array($apps) && count($apps) > 0) {
?>
    <table class="table table-hover table-striped"><thead>
    <tr>
    	<th>Application</th>
    	<th>Line</th>
    	<th>Protocol</th>
    	<th>Source Port(s)</th>
    	<th>Destination Port(s)</th>
    	<th>Details</th>
    </tr>
</thead><tbody>

<?php 
    foreach($apps as $app) {
        echo "<tr>";
        foreach (['app_name', 'app_line', 'protocol', 'source_port', 'destination_port', 'inactivity_timeout'] as $param) {
            echo "<td>".Html::encode($app->$param)."</td>";
        }
        echo "</tr>\n";
    }
?>

</tbody></table>
<?php     
} else {
    echo "<p>No Application Aliases</p>\n";
}

?>

<h3>Application Sets</h3>

<?php 
if(is_array($appSets) && count($appSets) > 0) {
?>
    <table class="table table-hover table-striped"><thead>
    <tr>
    	<th>Set</th>
    	<th>Type</th>
    	<th>Application or Set</th>
    </tr>
</thead><tbody>

<?php 
    $last = '';
    foreach($appSets as $app) {
        if ($last != '' && $last != $app->app_set_name) {
            echo "<tr><td colspan=3 class='info'></td></tr>";
        }
        
        echo "<tr>";
        foreach (['app_set_name', 'app_sub_type', 'app_sub_name'] as $param) {
            echo "<td>".Html::encode($app->$param)."</td>";
        }
        echo "</tr>\n";
        
        $last = $app->app_set_name;
    }
?>

</tbody></table>
<?php     
} else {
    echo "<p>No Application Sets</p>\n";
}

?>

<h2>Address Book</h2>

<?php 
if(is_array($addresses) && count($addresses) > 0) {
?>
    <table class="table table-hover table-striped"><thead>
    <tr>
    	<th>Zone</th>
    	<th>Label</th>
    	<th>Target</th>
    </tr>
</thead><tbody>

<?php 
    $last = '';
    foreach($addresses as $app) {
        if ($last != '' && $last != $app->fw_zone) {
            echo "<tr><td colspan=3 class='info'></td></tr>";
        }
        
        echo "<tr>";
        foreach (['fw_zone', 'name', 'ip'] as $param) {
            echo "<td>".Html::encode($app->$param)."</td>";
        }
        echo "</tr>\n";
        
        $last = $app->fw_zone;
    }
?>

</tbody></table>
<?php     
} else {
    echo "<p>No Application Sets</p>\n";
}

?>