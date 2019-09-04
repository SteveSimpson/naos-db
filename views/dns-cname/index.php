<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\db\DnsCnameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['location/index']];
$this->params['breadcrumbs'][] = ['label' => 'Networks', 'url' => ['network/index']];
$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['host/index']];
$this->title = 'DNS CNames';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dns-cname-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create DNS CName', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'domain',
            'cname',
            'target',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
