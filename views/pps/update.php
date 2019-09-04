<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\db\FwConfig */

$this->title = 'Update Fw Config: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fw Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fw-config-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
