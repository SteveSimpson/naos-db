<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\db\DnsCname */

$this->title = 'Create DNS CName';
$this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['location/index']];
$this->params['breadcrumbs'][] = ['label' => 'Networks', 'url' => ['network/index']];
$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['host/index']];
$this->params['breadcrumbs'][] = ['label' => 'DNS CNames', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dns-cname-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'domains' => $domains,
    ]) ?>

</div>
