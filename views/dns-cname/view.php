<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\db\DnsCname */

$this->title = $model->cname . "." . $model->domain;
$this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['location/index']];
$this->params['breadcrumbs'][] = ['label' => 'Networks', 'url' => ['network/index']];
$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['host/index']];
$this->params['breadcrumbs'][] = ['label' => 'DNS CNames', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dns-cname-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
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
            'domain',
            'cname',
            'target',
        ],
    ]) ?>

</div>
