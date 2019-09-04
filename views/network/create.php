<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\db\Network */

$this->title = 'Create Network';
$this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['location/index']];
$this->params['breadcrumbs'][] = ['label' => 'Networks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['host/index']];
$this->params['breadcrumbs'][] = ['label' => 'DNS CNames', 'url' => ['dns-cname/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="network-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'locations' => $locations,
    ]) ?>

</div>
