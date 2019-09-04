<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\db\Host */

$this->title = 'Create Host';
$this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['location/index']];
$this->params['breadcrumbs'][] = ['label' => 'Networks', 'url' => ['network/index']];
$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'DNS CName', 'url' => ['dns-cname/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="host-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'networks' => $networks,
    ]) ?>

</div>
