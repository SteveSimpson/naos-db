<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\db\SoftwareSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="software-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'version') ?>

    <?= $form->field($model, 'manufacturer') ?>

    <?php // echo $form->field($model, 'license_or_contract') ?>

    <?php // echo $form->field($model, 'licenses_total') ?>

    <?php // echo $form->field($model, 'licenses_used') ?>

    <?php // echo $form->field($model, 'dod_approval') ?>

    <?php // echo $form->field($model, 'critical') ?>

    <?php // echo $form->field($model, 'stig') ?>

    <?php // echo $form->field($model, 'hosts_os_notes') ?>

    <?php // echo $form->field($model, 'support_links') ?>

    <?php // echo $form->field($model, 'other_notes') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
