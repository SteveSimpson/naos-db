<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\db\FwConfig */

$this->title = 'Create Fw Config';
$this->params['breadcrumbs'][] = ['label' => 'Fw Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fw-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
