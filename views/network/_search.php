<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\db\NetworkSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="network-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'network_name') ?>

    <?= $form->field($model, 'location_name') ?>

    <?= $form->field($model, 'prefix4') ?>

    <?= $form->field($model, 'prefix6') ?>

    <?php // echo $form->field($model, 'mask4') ?>

    <?php // echo $form->field($model, 'mask6') ?>

    <?php // echo $form->field($model, 'dnsdomain') ?>

    <?php // echo $form->field($model, 'notes') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
