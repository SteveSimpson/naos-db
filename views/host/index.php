<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\db\HostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hosts';
$this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['location/index']];
$this->params['breadcrumbs'][] = ['label' => 'Networks', 'url' => ['network/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'DNS CNames', 'url' => ['dns-cname/index']];
?>
<div class="host-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Host', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('DNS Zones', ['zones'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('/etc/hosts', ['etc-hosts'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Checklist', ['check-list'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Host List', ['check-list','format'=>'text'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'hostname',
            'fqdn',
            'network_name',
            'location_name',
            'service',
            'ipv4',
            //'ipv6',
            //'mask4',
            //'mask6',
            //'monitor_ip',
            'enabled:boolean',
            //'notes:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
