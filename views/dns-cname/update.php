<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\db\DnsCname */

$this->title = 'Update DNS CName: ' . $model->cname . "." . $model->domain;
$this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['location/index']];
$this->params['breadcrumbs'][] = ['label' => 'Networks', 'url' => ['network/index']];
$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['host/index']];
$this->params['breadcrumbs'][] = ['label' => 'DNS CNames', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cname . "." . $model->domain, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dns-cname-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'domains' => $domains,
    ]) ?>

</div>
