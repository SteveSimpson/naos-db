<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\db\FwConfig */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fw Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fw-config-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    	<?php
    	if($pps) {
    	    echo Html::a('PPS', ['show', 'name' => $pps->fw_name], ['class' => 'btn btn-success pull-right']);
    	    echo "<div class='pull-right'>&nbsp;</div>";
    	    echo Html::a('Rules', ['rules', 'name' => $pps->fw_name], ['class' => 'btn btn-info pull-right']);
    	}
    	?>
    	
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fw_name',
            'fw_type',
            'fw_config:ntext',
            'notes:ntext',
        ],
    ]) ?>

</div>
