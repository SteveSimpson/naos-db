<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\db\SoftwareSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Software Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="software-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Software', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Software List', ['software-list'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'type',
            'version',
            'manufacturer',
            //'license_or_contract',
            //'licenses_total',
            //'licenses_used',
            //'dod_approval',
            //'critical',
            'stig',
            //'hosts_os_notes:ntext',
            //'support_links:ntext',
            //'other_notes:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
