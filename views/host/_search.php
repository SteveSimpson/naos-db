<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\db\HostSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="host-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'hostname') ?>

    <?= $form->field($model, 'fqdn') ?>

    <?= $form->field($model, 'network_name') ?>

    <?= $form->field($model, 'location_name') ?>

    <?php // echo $form->field($model, 'service') ?>

    <?php // echo $form->field($model, 'ipv4') ?>

    <?php // echo $form->field($model, 'ipv6') ?>

    <?php // echo $form->field($model, 'mask4') ?>

    <?php // echo $form->field($model, 'mask6') ?>

    <?php // echo $form->field($model, 'monitor_ip') ?>

    <?php // echo $form->field($model, 'enabled') ?>

    <?php // echo $form->field($model, 'notes') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
