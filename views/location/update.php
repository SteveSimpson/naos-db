<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\db\Location */

$this->title = 'Update Location: ' . $model->location_name;
$this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Networks', 'url' => ['network/index']];
$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['host/index']];
$this->params['breadcrumbs'][] = ['label' => 'DNS CName', 'url' => ['dns-cname/index']];
$this->params['breadcrumbs'][] = ['label' => 'Location: '.$model->location_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="location-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
